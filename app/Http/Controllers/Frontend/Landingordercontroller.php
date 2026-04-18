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
            'customer_name'    => 'required|string|max:120',
            'customer_phone'   => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'shipping_area'    => 'nullable|string|max:150',
            'delivery_charge'  => 'required|numeric|min:0',
            'subtotal'         => 'required|numeric|min:0',
            'grand_total'      => 'required|numeric|min:0',
            'campaign_id'      => 'required|exists:campaigncreates,id',
            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty'        => 'required|integer|min:1',
            'items.*.price'      => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // ── Create Order ───────────────────────────────────────
            $order = Order::create([
                'order_number'   => Order::generateOrderNumber(),
                'user_id'        => null,   // guest order from landing page
                'customer_name'  => $request->customer_name,
                'phone'          => $request->customer_phone,
                'address'        => $request->customer_address,
                'delivery_area'  => $request->shipping_area ?? '',
                'note'           => 'Campaign ID: ' . $request->campaign_id,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'order_status'   => 'pending',
                'subtotal'       => $request->subtotal,
                'discount'       => 0,
                'delivery_fee'   => $request->delivery_charge,
                'total'          => $request->grand_total,
                'coupon_code'    => null,
                'source'         => 'landing_page',   // helpful for reports — add this column if needed
                'campaign_id'    => $request->campaign_id,
            ]);

            // ── Create Order Items ─────────────────────────────────
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) continue;

                OrderItem::create([
                    'order_id'       => $order->id,
                    'product_id'     => $product->id,
                    'product_name'   => $product->name,
                    'product_image'  => $product->feature_image,
                    'product_slug'   => $product->slug ?? null,
                    'price'          => $item['price'],
                    'original_price' => $product->current_price,
                    'quantity'       => $item['qty'],
                    'subtotal'       => $item['price'] * $item['qty'],
                    'selected_color' => null,
                    'selected_size'  => null,
                ]);

                // ── Decrement stock if not unlimited ───────────────
                if (!$product->is_unlimited && $product->stock !== null) {
                    $product->decrement('stock', $item['qty']);
                }
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'অর্ডার প্রক্রিয়া করতে সমস্যা হয়েছে। আবার চেষ্টা করুন।',
            ], 500);
        }

        return response()->json([
            'success'  => true,
            'message'  => 'অর্ডার সফল হয়েছে!',
            'order_id' => $order->id,
            'redirect' => route('order.success', $order->order_number),
        ]);
    }
}
