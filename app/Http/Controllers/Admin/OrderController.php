<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // ── Create Form ───────────────────────────────────────────────
    public function create()
    {
        $products = Product::where('status', 1)->latest()->get();
        return view('admin.orders.create_edit', compact('products'));
    }

    // ── Store New Order ───────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'customer_name'      => 'required|string|max:255',
            'phone'              => 'required|string|max:20',
            'address'            => 'required|string|max:500',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'order_number'   => Order::generateOrderNumber(),
            'customer_name'  => $request->customer_name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'delivery_area'  => $request->delivery_area  ?? null,
            'note'           => $request->note            ?? null,
            'subtotal'       => $request->subtotal        ?? 0,
            'discount'       => $request->discount        ?? 0,
            'delivery_fee'   => $request->delivery_fee    ?? 0,
            'total'          => $request->total           ?? 0,
            'order_status'   => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method  ?? 'cod',
        ]);

        $this->syncItems($order, $request->items);

        return redirect()
            ->route('admin.order.show', $order->id)
            ->with('success', 'অর্ডার সফলভাবে তৈরি হয়েছে।');
    }

    // ── Edit Form ─────────────────────────────────────────────────
    public function edit($id)
    {
        $order    = Order::with('items.product')->findOrFail($id);
        $products = Product::where('status', 1)->latest()->get();
        return view('admin.orders.create_edit', compact('order', 'products'));
    }

    // ── Update Order ──────────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name'      => 'required|string|max:255',
            'phone'              => 'required|string|max:20',
            'address'            => 'required|string|max:500',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($id);

        $order->update([
            'customer_name' => $request->customer_name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'delivery_area' => $request->delivery_area ?? null,
            'note'          => $request->note           ?? null,
            'subtotal'      => $request->subtotal       ?? 0,
            'discount'      => $request->discount       ?? 0,
            'delivery_fee'  => $request->delivery_fee   ?? 0,
            'total'         => $request->total          ?? 0,
        ]);

        $order->items()->delete();
        $this->syncItems($order, $request->items);

        return redirect()
            ->route('admin.order.show', $order->id)
            ->with('success', 'অর্ডার সফলভাবে আপডেট হয়েছে।');
    }

    // ── Private Helper: insert order items ───────────────────────
    private function syncItems(Order $order, array $items): void
    {
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if (! $product) {
                continue;
            }

            $originalPrice = (float) $product->price;
            $price         = ($product->discount_price > 0)
                                ? (float) $product->discount_price
                                : $originalPrice;
            $qty           = (int) $item['quantity'];
            $subtotal      = $qty * $price;

            OrderItem::create([
                'order_id'       => $order->id,
                'product_id'     => $product->id,
                'product_name'   => $product->name,
                'product_image'  => $product->feature_image ?? null,
                'product_slug'   => $product->slug          ?? null,
                'price'          => $price,
                'original_price' => $originalPrice,
                'quantity'       => $qty,
                'subtotal'       => $subtotal,
            ]);
        }
    }
}
