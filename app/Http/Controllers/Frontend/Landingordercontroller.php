<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Campaigncreate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingOrderController extends Controller
{
    /**
     * POST /landing/order/store
     * Called via fetch() from the campaign landing page.
     * Returns JSON.
     */
    public function store(Request $request)
    {
        // ── Validate ───────────────────────────────────────────────
        $request->validate([
            'name'             => 'required|string|max:120',
            'phone'            => 'required|string|max:20',
            'address'          => 'required|string|max:500',
            'shipping_area'    => 'required|string',
            'product_id'       => 'nullable|exists:products,id', // Make nullable if cart is present
            'landing_page_id'  => 'nullable|exists:landing_pages,id',
            'campaign_id'      => 'nullable|exists:campaigncreates,id',
            'cart'             => 'nullable|array',
        ]);

        // ── Fraud Profile Block Check ──────────────────────────────
        $clientIp = $request->ip();
        $fraudProfile = \App\Models\FraudProfile::where(function($q) use ($request, $clientIp) {
            $q->where('phone', $request->phone)
              ->orWhere('ip_address', $clientIp);
        })->where('is_blocked', true)->first();

        if ($fraudProfile) {
            return response()->json([
                'success' => false, 
                'message' => 'দুঃখিত, আপনার ফোন নম্বর বা IP আমাদের সিস্টেমে ব্লক করা হয়েছে।'
            ], 403);
        }

        $subtotal = 0;
        $orderItemsData = [];

        if ($request->has('cart') && count($request->cart) > 0) {
            foreach ($request->cart as $item) {
                $product = Product::find($item['id']);
                if (!$product) continue;

                $price = (float) ($product->discount_price ?? $product->current_price);
                $qty = (int) ($item['qty'] ?? 1);
                $itemSubtotal = $price * $qty;
                $subtotal += $itemSubtotal;

                $orderItemsData[] = [
                    'product_id'     => $product->id,
                    'product_name'   => $product->name,
                    'product_image'  => $product->feature_image,
                    'product_slug'   => $product->slug,
                    'price'          => $price,
                    'original_price' => $product->current_price,
                    'quantity'       => $qty,
                    'subtotal'       => $itemSubtotal,
                    'product_obj'    => $product
                ];
            }
        } else {
            // Fallback to single product
            $product = Product::find($request->product_id);
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'প্রোডাক্ট পাওয়া যায়নি!'], 400);
            }
            $price = (float) ($product->discount_price ?? $product->current_price);
            $qty = (int) ($request->quantity ?? 1);
            $subtotal = $price * $qty;

            $orderItemsData[] = [
                'product_id'     => $product->id,
                'product_name'   => $product->name,
                'product_image'  => $product->feature_image,
                'product_slug'   => $product->slug,
                'price'          => $price,
                'original_price' => $product->current_price,
                'quantity'       => $qty,
                'subtotal'       => $subtotal,
                'product_obj'    => $product
            ];
        }

        if (count($orderItemsData) === 0) {
            return response()->json(['success' => false, 'message' => 'কার্ট খালি!'], 400);
        }

        $shippingCost = 0;
        if ($request->shipping_area == 'inside') $shippingCost = 70;
        elseif ($request->shipping_area == 'outside') $shippingCost = 130;
        else $shippingCost = (float) $request->shipping_area;

        $grandTotal = $subtotal + $shippingCost;

        DB::beginTransaction();
        try {
            // ── Create Order ───────────────────────────────────────
            $order = Order::create([
                'order_number'   => Order::generateOrderNumber(),
                'user_id'        => null, 
                'customer_name'  => $request->name,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'delivery_area'  => $request->shipping_area,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'order_status'   => 'pending',
                'subtotal'       => $subtotal,
                'delivery_fee'   => $shippingCost,
                'total'          => $grandTotal,
                'source'         => 'landing_page',
                'landing_page_id'=> $request->landing_page_id,
                'campaign_id'    => $request->campaign_id,
                'note'           => $request->landing_page_id ? 'Landing Page Order' : 'Campaign Order',
                'ip_address'     => $request->ip(),
            ]);

            // ── Create Order Items ──────────────────────────────────
            foreach ($orderItemsData as $item) {
                OrderItem::create([
                    'order_id'       => $order->id,
                    'product_id'     => $item['product_id'],
                    'product_name'   => $item['product_name'],
                    'product_image'  => $item['product_image'],
                    'product_slug'   => $item['product_slug'],
                    'price'          => $item['price'],
                    'original_price' => $item['original_price'],
                    'quantity'       => $item['quantity'],
                    'subtotal'       => $item['subtotal'],
                ]);

                // Stock
                $product = $item['product_obj'];
                if (!$product->is_unlimited && $product->stock !== null) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();

            return response()->json([
                'success'  => true,
                'message'  => 'অর্ডার সফল হয়েছে!',
                'redirect' => route('order.success', $order->order_number),
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'দুঃখিত! অর্ডারটি সম্পন্ন করা সম্ভব হয়নি। ' . $e->getMessage(),
            ], 500);
        }
    }
}

