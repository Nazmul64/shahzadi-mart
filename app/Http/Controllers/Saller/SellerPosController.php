<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use App\Models\Alltaxe;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\PosSession;
use App\Models\PosSessionItem;
use App\Models\ShippingCharge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SellerPosController extends Controller
{
    // ══════════════════════════════════════════════════════════
    // 1. POS INDEX
    // ══════════════════════════════════════════════════════════
    public function index(Request $request)
    {
        $sellerId = auth()->id();

        // Get only categories, brands, colors, sizes used by this seller's products
        $sellerProductIds = Product::where('vendor', $sellerId)->pluck('id');

        $categories = Category::where('status', 'active')
            ->whereIn('id', Product::where('vendor', $sellerId)->distinct()->pluck('category_id'))
            ->orderBy('category_name')
            ->get(['id', 'category_name']);

        $brands = Brand::where('is_active', true)
            ->whereIn('id', function($query) use ($sellerId) {
                $query->selectRaw('JSON_UNQUOTE(JSON_EXTRACT(brand_ids, "$[0]"))')
                      ->from('products')
                      ->where('vendor', $sellerId)
                      ->whereNotNull('brand_ids');
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        $colors = Color::where('is_active', true)
            ->whereIn('id', function($query) use ($sellerId) {
                $query->selectRaw('JSON_UNQUOTE(JSON_EXTRACT(color_ids, "$[0]"))')
                      ->from('products')
                      ->where('vendor', $sellerId)
                      ->whereNotNull('color_ids');
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        $sizes = Size::where('is_active', true)
            ->whereIn('id', function($query) use ($sellerId) {
                $query->selectRaw('JSON_UNQUOTE(JSON_EXTRACT(size_ids, "$[0]"))')
                      ->from('products')
                      ->where('vendor', $sellerId)
                      ->whereNotNull('size_ids');
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        $taxes = Alltaxe::where('status', true)->get(['name', 'percentage']);

        $shippingCharges = ShippingCharge::active()
            ->orderBy('area_name')
            ->get(['id', 'area_name', 'amount']);

        $query = Product::with('category')->where('vendor', $sellerId)->where('status', 'active');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('brand_id')) {
            $query->whereJsonContains('brand_ids', (string)$request->brand_id);
        }
        if ($request->filled('color_id')) {
            $query->whereJsonContains('color_ids', (string)$request->color_id);
        }
        if ($request->filled('size_id')) {
            $query->whereJsonContains('size_ids', (string)$request->size_id);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('saller.pos.index', compact(
            'categories', 'brands', 'colors', 'sizes', 'taxes', 'products', 'shippingCharges'
        ));
    }

    // ══════════════════════════════════════════════════════════
    // 2. SEARCH PRODUCTS (AJAX)
    // ══════════════════════════════════════════════════════════
    public function searchProducts(Request $request): JsonResponse
    {
        $sellerId = auth()->id();
        $query = Product::with('category')->where('vendor', $sellerId)->where('status', 'active');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('brand_id')) {
            $query->whereJsonContains('brand_ids', (string)$request->brand_id);
        }
        if ($request->filled('color_id')) {
            $query->whereJsonContains('color_ids', (string)$request->color_id);
        }
        if ($request->filled('size_id')) {
            $query->whereJsonContains('size_ids', (string)$request->size_id);
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return response()->json([
            'success' => true,
            'html'    => view('saller.pos.partials.product_grid', compact('products'))->render(),
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

        // Searching in User model as per Seller Dashboard logic
        $customers = \App\Models\User::where('seller_id', auth()->id())
            ->where(function ($query) use ($q) {
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
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'email'      => 'nullable|email|unique:users,email',
            'password'   => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Saving to User model with seller_id to match dashboard logic
        $customer = \App\Models\User::create([
            'seller_id'  => auth()->id(),
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'name'       => $request->first_name . ' ' . $request->last_name,
            'phone'      => $request->phone,
            'email'      => $request->email ?? null,
            'password'   => Hash::make($request->password),
            'status'     => 'active',
        ]);

        // Assign customer role if needed (optional but good for consistency)
        $customer->addRole('customer');

        return response()->json([
            'success'  => true,
            'message'  => 'Customer created!',
            'customer' => [
                'id'    => $customer->id,
                'name'  => $customer->name,
                'phone' => $customer->phone,
                'email' => $customer->email,
            ],
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
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.'], 404);
        }

        $today = Carbon::today();
        if ($coupon->start_date && $today->lt($coupon->start_date)) {
            return response()->json(['success' => false, 'message' => 'Coupon not active yet.'], 422);
        }
        if ($coupon->end_date && $today->gt($coupon->end_date)) {
            return response()->json(['success' => false, 'message' => 'Coupon expired.'], 422);
        }

        $subTotal = (float) $request->sub_total;
        $discount = ($coupon->type === 'discount_by_percentage')
            ? round($subTotal * ($coupon->percentage / 100), 2)
            : min((float) $coupon->amount, $subTotal);

        return response()->json([
            'success'         => true,
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
            'sub_total'          => 'required|numeric',
            'grand_total'        => 'required|numeric',
            'status'             => 'required|in:draft,completed',
            'payment_method'     => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();
        try {
            $session = PosSession::create([
                'invoice_no'      => PosSession::generateInvoiceNo(),
                'customer_id'     => $request->customer_id ?: null,
                'created_by'      => auth()->id(),
                'sub_total'       => $request->sub_total,
                'discount_amount' => $request->discount_amount ?? 0,
                'tax_amount'      => $request->tax_amount ?? 0,
                'shipping_amount' => $request->shipping_amount ?? 0,
                'grand_total'     => $request->grand_total,
                'coupon_code'     => $request->coupon_code,
                'coupon_discount' => $request->coupon_discount ?? 0,
                'status'          => $request->status,
                'payment_method'  => $request->payment_method,
                'note'            => $request->note,
            ]);

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                PosSessionItem::create([
                    'pos_session_id' => $session->id,
                    'product_id'     => $product->id,
                    'variant_label'  => $item['variant_label'] ?? null,
                    'unit_price'     => $item['unit_price'],
                    'quantity'       => $item['quantity'],
                    'total_price'    => $item['unit_price'] * $item['quantity'],
                ]);

                if ($request->status === 'completed' && ! $product->is_unlimited) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();
            return response()->json([
                'success'    => true,
                'session_id' => $session->id,
                'invoice_no' => $session->invoice_no,
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function orders(Request $request)
    {
        $sessions = PosSession::where('created_by', auth()->id())
            ->with('customer')
            ->latest()
            ->paginate(20);
        return view('saller.pos.orders', compact('sessions'));
    }

    public function invoice(PosSession $session)
    {
        if ($session->created_by != auth()->id()) abort(403);
        $session->load(['items.product', 'customer']);
        $taxes = Alltaxe::where('status', true)->get();
        return view('saller.pos.invoice', compact('session', 'taxes'));
    }

    public function cancelOrder(PosSession $session)
    {
        if ($session->created_by != auth()->id()) abort(403);
        if ($session->status === 'cancelled') return response()->json(['success'=>false, 'message'=>'Already cancelled']);

        DB::beginTransaction();
        try {
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
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
