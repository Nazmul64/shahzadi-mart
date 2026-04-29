<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alltaxe;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PosSession;
use App\Models\PosSessionItem;
use App\Models\ShippingCharge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PosController extends Controller
{
    // ══════════════════════════════════════════════════════════
    // 1. POS INDEX
    // ══════════════════════════════════════════════════════════
    public function index(Request $request)
    {
        $categories = Category::where('status', 'active')
            ->orderBy('category_name')
            ->get(['id', 'category_name']);

        $taxes = Alltaxe::where('status', true)
            ->get(['name', 'percentage']);

        $shippingCharges = ShippingCharge::active()
            ->orderBy('area_name')
            ->get(['id', 'area_name', 'amount']);

        $brands = Product::where('status', 'active')
            ->whereNotNull('vendor')
            ->where('vendor', '!=', '')
            ->distinct()
            ->pluck('vendor');

        $query = Product::with('category')->where('status', 'active');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('brand')) {
            $query->where('vendor', $request->brand);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('admin.pos.index', compact(
            'categories', 'taxes', 'products', 'brands', 'shippingCharges'
        ));
    }

    // ══════════════════════════════════════════════════════════
    // 2. SEARCH PRODUCTS (AJAX)
    // ══════════════════════════════════════════════════════════
    public function searchProducts(Request $request): JsonResponse
    {
        $query = Product::with('category')->where('status', 'active');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('brand')) {
            $query->where('vendor', $request->brand);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return response()->json([
            'success' => true,
            'html'    => view('admin.pos.partials.product_grid', compact('products'))->render(),
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // 3. SEARCH CUSTOMERS (AJAX)
    // ══════════════════════════════════════════════════════════
    public function searchCustomers(Request $request): JsonResponse
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 1) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $customers = Customer::where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('phone', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'phone', 'email']);

        return response()->json([
            'success' => true,
            'data'    => $customers,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // 4. STORE CUSTOMER (AJAX)
    // ══════════════════════════════════════════════════════════
    public function storeCustomer(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'email' => 'nullable|email|unique:customers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $customer = Customer::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'email'    => $request->email ?? null,
            'address'  => '',
            'password' => bcrypt(str()->random(10)),
            'status'   => 'active',
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Customer created!',
            'customer' => $customer->only('id', 'name', 'phone', 'email'),
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // 5. APPLY COUPON (AJAX)
    // ══════════════════════════════════════════════════════════
    public function applyCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code'      => 'required|string',
            'sub_total' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('status', 'activated')
            ->first();

        if (! $coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code.',
            ], 404);
        }

        $today = Carbon::today();

        if ($coupon->start_date && $today->lt($coupon->start_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon not active yet.',
            ], 422);
        }
        if ($coupon->end_date && $today->gt($coupon->end_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon expired.',
            ], 422);
        }
        if ($coupon->quantity === 'limited' && $coupon->used >= $coupon->quantity_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit reached.',
            ], 422);
        }

        $subTotal = (float) $request->sub_total;
        $discount = 0;

        if ($coupon->type === 'discount_by_percentage') {
            $discount = round($subTotal * ($coupon->percentage / 100), 2);
        } else {
            $discount = min((float) $coupon->amount, $subTotal);
        }

        return response()->json([
            'success'         => true,
            'message'         => 'Coupon applied!',
            'discount_amount' => $discount,
            'coupon_code'     => $coupon->code,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // 6. PLACE ORDER (AJAX)
    // ══════════════════════════════════════════════════════════
    public function placeOrder(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
            'sub_total'          => 'required|numeric|min:0',
            'tax_amount'         => 'required|numeric|min:0',
            'grand_total'        => 'required|numeric|min:0',
            'status'             => 'required|in:draft,completed',
            'shipping_charge_id' => 'nullable|exists:shipping_charges,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Resolve shipping amount
        $shippingAmount = 0;
        if ($request->filled('shipping_charge_id')) {
            $sc = ShippingCharge::find($request->shipping_charge_id);
            if ($sc) {
                $shippingAmount = (float) $sc->amount;
            }
        }

        DB::beginTransaction();
        try {
            $session = PosSession::create([
                'invoice_no'      => PosSession::generateInvoiceNo(),
                'customer_id'     => $request->customer_id ?: null,
                'created_by'      => auth()->id(),
                'sub_total'       => $request->sub_total,
                'discount_amount' => $request->discount_amount ?? 0,
                'tax_amount'      => $request->tax_amount,
                'shipping_amount' => $shippingAmount,          // ✅ এখন কাজ করবে
                'grand_total'     => $request->grand_total,
                'coupon_code'     => $request->coupon_code,
                'coupon_discount' => $request->coupon_discount ?? 0,
                'status'          => $request->status,
                'payment_method'  => $request->payment_method ?? 'cash',
                'note'            => $request->note,
            ]);

            foreach ($request->items as $item) {
                $product   = Product::findOrFail($item['product_id']);
                $unitPrice = $item['unit_price'] ?? $product->effective_price;

                PosSessionItem::create([
                    'pos_session_id' => $session->id,
                    'product_id'     => $product->id,
                    'variant_label'  => $item['variant_label'] ?? null,
                    'unit_price'     => $unitPrice,
                    'quantity'       => $item['quantity'],
                    'total_price'    => $unitPrice * $item['quantity'],
                ]);

                // Deduct stock only on completed orders
                if ($request->status === 'completed' && ! $product->is_unlimited) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            // Increment coupon usage on completed orders
            if ($request->filled('coupon_code') && $request->status === 'completed') {
                Coupon::where('code', $request->coupon_code)->increment('used');
            }

            DB::commit();

            return response()->json([
                'success'    => true,
                'message'    => $request->status === 'draft'
                    ? 'Saved as draft.'
                    : 'Order completed!',
                'session_id' => $session->id,
                'invoice_no' => $session->invoice_no,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ══════════════════════════════════════════════════════════
    // 7. INVOICE VIEW
    // ══════════════════════════════════════════════════════════
    public function invoice(PosSession $session)
    {
        $session->load(['items.product', 'customer']);
        $taxes = Alltaxe::where('status', true)->get();

        return view('admin.pos.invoice', compact('session', 'taxes'));
    }

    // ══════════════════════════════════════════════════════════
    // 8. ORDERS LIST
    // ══════════════════════════════════════════════════════════
    public function orders(Request $request)
    {
        $query = PosSession::with('customer')
            ->withCount('items')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('invoice_no', 'like', '%' . $request->search . '%');
        }

        $sessions = $query->paginate(20)->withQueryString();

        return view('admin.pos.orders', compact('sessions'));
    }

    // ══════════════════════════════════════════════════════════
    // 9. CANCEL ORDER (AJAX)
    // ══════════════════════════════════════════════════════════
    public function cancelOrder(Request $request, PosSession $session): JsonResponse
    {
        if ($session->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Order already cancelled.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Restore stock if was completed
            if ($session->status === 'completed') {
                foreach ($session->items as $item) {
                    $product = $item->product;
                    if ($product && ! $product->is_unlimited) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }

            $session->update(['status' => 'cancelled']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully.',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
