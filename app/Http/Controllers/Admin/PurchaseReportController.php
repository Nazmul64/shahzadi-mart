<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;

class PurchaseReportController extends Controller
{
    /**
     * Stock Report — Purchased(In) | Sold(Out) | Available Stock
     * Note: Orders table uses 'order_status' column (not 'status')
     */
    public function stockReport(Request $request)
    {
        $allProducts = Product::orderBy('name')->get();

        $query = Product::query()->orderBy('name');
        if ($request->filled('product_id')) {
            $query->where('id', $request->product_id);
        }

        $products = $query->get()->map(function ($product) use ($request) {

            /* ── Purchased (In) — only 'received' purchases ─────────── */
            $purchasedQ = PurchaseItem::where('product_id', $product->id)
                ->whereHas('purchase', fn($q) => $q->where('status', 'received'));

            if ($request->filled('filter_date')) {
                $purchasedQ->whereHas('purchase',
                    fn($q) => $q->whereDate('purchase_date', $request->filter_date));
            }

            /* ── Sold (Out) — exclude cancelled orders ───────────────── */
            $soldQ = OrderItem::where('product_id', $product->id)
                ->whereHas('order',
                    fn($q) => $q->where('order_status', '!=', 'cancelled'));

            if ($request->filled('filter_date')) {
                $soldQ->whereHas('order',
                    fn($q) => $q->whereDate('created_at', $request->filter_date));
            }

            return [
                'id'        => $product->id,
                'name'      => $product->name,
                'purchased' => (int) $purchasedQ->sum('quantity'),
                'sold'      => (int) $soldQ->sum('quantity'),
                'stock'     => (int) $product->stock,
            ];
        });

        return view('admin.purchases.stock_report', compact('products', 'allProducts'));
    }

    /**
     * Export Stock Report as CSV/Excel
     */
    public function exportStockExcel(Request $request)
    {
        $products = Product::orderBy('name')->get()->map(function ($product) {
            $purchased = PurchaseItem::where('product_id', $product->id)
                ->whereHas('purchase', fn($q) => $q->where('status', 'received'))
                ->sum('quantity');

            $sold = OrderItem::where('product_id', $product->id)
                ->whereHas('order', fn($q) => $q->where('order_status', '!=', 'cancelled'))
                ->sum('quantity');

            return [
                'name'      => $product->name,
                'purchased' => (int) $purchased,
                'sold'      => (int) $sold,
                'stock'     => (int) $product->stock,
            ];
        });

        $filename = 'stock_report_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM for Excel
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['SN', 'Product Name', 'Purchased (In)', 'Sold (Out)', 'Available Stock']);
            foreach ($products as $i => $p) {
                fputcsv($handle, [$i + 1, $p['name'], $p['purchased'], $p['sold'], $p['stock']]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
