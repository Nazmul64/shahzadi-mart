<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /* ─────────────────────────────────────────────
     * Purchase Invoices Index
     * ───────────────────────────────────────────── */
    public function index(Request $request)
    {
        $query = Purchase::with('supplier')->latest();

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $purchases = $query->paginate(20);
        $suppliers  = Supplier::where('status', true)->get();

        return view('manager.purchases.index', compact('purchases', 'suppliers'));
    }

    /* ─────────────────────────────────────────────
     * Create Form
     * ───────────────────────────────────────────── */
    public function create()
    {
        $suppliers = Supplier::where('status', true)->get();
        return view('manager.purchases.create', compact('suppliers'));
    }

    /* ─────────────────────────────────────────────
     * Store — image → uploads/purchase
     * ───────────────────────────────────────────── */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'    => 'required|exists:suppliers,id',
            'title'          => 'nullable|string|max:255',
            'purchase_date'  => 'required|date',
            'notes'          => 'nullable|string',
            'lot_slip_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $data = $request->only(['supplier_id', 'title', 'purchase_date', 'notes']);
        $data['purchase_number'] = Purchase::generatePurchaseNumber();
        $data['status']          = 'pending';

        if ($request->hasFile('lot_slip_image')) {
            $dir      = public_path('uploads/purchase');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $file     = $request->file('lot_slip_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $data['lot_slip_image'] = $filename;
        }

        $purchase = Purchase::create($data);

        return redirect()->route('admin.purchases.show', $purchase->id)
                         ->with('success', 'Purchase created. Now attach products.');
    }

    /* ─────────────────────────────────────────────
     * Show / Details
     * ───────────────────────────────────────────── */
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product']);
        $products = Product::where('status', 1)->orderBy('name')->get();
        return view('manager.purchases.show', compact('purchase', 'products'));
    }

    /* ─────────────────────────────────────────────
     * Attach a product item
     * ───────────────────────────────────────────── */
    public function attachItems(Request $request, Purchase $purchase)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ]);

        if ($purchase->status === 'received') {
            return back()->with('error', 'Cannot add items to a received purchase.');
        }

        $total_price = $request->quantity * $request->unit_price;

        DB::transaction(function () use ($request, $purchase, $total_price) {
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id'  => $request->product_id,
                'quantity'    => $request->quantity,
                'unit_price'  => $request->unit_price,
                'total_price' => $total_price,
            ]);
            $purchase->increment('total_amount', $total_price);
        });

        return back()->with('success', 'Product added successfully.');
    }

    /* ─────────────────────────────────────────────
     * Remove an item
     * ───────────────────────────────────────────── */
    public function removeItem(PurchaseItem $item)
    {
        $purchase = $item->purchase;
        if ($purchase->status === 'received') {
            return back()->with('error', 'Cannot remove items from a received purchase.');
        }

        DB::transaction(function () use ($item, $purchase) {
            $purchase->decrement('total_amount', $item->total_price);
            $item->delete();
        });

        return back()->with('success', 'Item removed.');
    }

    /* ─────────────────────────────────────────────
     * Mark as Received — increments product stock
     * ───────────────────────────────────────────── */
    public function markAsReceived(Purchase $purchase)
    {
        if ($purchase->status === 'received') {
            return back()->with('info', 'Already marked as received.');
        }

        DB::transaction(function () use ($purchase) {
            $purchase->update(['status' => 'received']);
            foreach ($purchase->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        });

        return back()->with('success', 'Purchase marked as received & stock updated.');
    }

    /* ─────────────────────────────────────────────
     * Delete
     * ───────────────────────────────────────────── */
    public function destroy(Purchase $purchase)
    {
        if ($purchase->status === 'received') {
            return back()->with('error', 'Cannot delete a received purchase.');
        }

        if ($purchase->lot_slip_image) {
            $path = public_path('uploads/purchase/' . $purchase->lot_slip_image);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $purchase->delete();
        return redirect()->route('manager.purchases.index')
                         ->with('success', 'Purchase deleted.');
    }

    /* ─────────────────────────────────────────────
     * Download PDF  (opens in new tab → auto print)
     * ───────────────────────────────────────────── */
    public function downloadPdf(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product']);
        return view('manager.purchases.pdf', compact('purchase'));
    }

    /* ─────────────────────────────────────────────
     * Export Excel (CSV)
     * ───────────────────────────────────────────── */
    public function exportExcel(Request $request)
    {
        $query = Purchase::with('supplier')->latest();

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $purchases = $query->get();

        $filename = 'purchases_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($purchases) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));   // UTF-8 BOM for Excel

            fputcsv($handle, ['#', 'Purchase Number', 'Supplier', 'Title', 'Date', 'Total Amount', 'Status']);

            foreach ($purchases as $i => $p) {
                fputcsv($handle, [
                    $i + 1,
                    $p->purchase_number,
                    $p->supplier->name ?? '—',
                    $p->title ?? '—',
                    $p->purchase_date,
                    $p->total_amount,
                    $p->status,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /* ─────────────────────────────────────────────
     * Purchase Summary
     * ───────────────────────────────────────────── */
    public function summary(Request $request)
    {
        $query = PurchaseItem::with(['purchase.supplier', 'product'])->whereHas('purchase');

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('purchase_id')) {
            $query->where('purchase_id', $request->purchase_id);
        }
        if ($request->filled('supplier_id')) {
            $query->whereHas('purchase', fn($q) => $q->where('supplier_id', $request->supplier_id));
        }
        if ($request->filled('from')) {
            $query->whereHas('purchase', fn($q) => $q->where('purchase_date', '>=', $request->from));
        }
        if ($request->filled('to')) {
            $query->whereHas('purchase', fn($q) => $q->where('purchase_date', '<=', $request->to));
        }

        $items     = $query->get();
        $products  = Product::where('status', 1)->orderBy('name')->get();
        $purchases = Purchase::orderByDesc('id')->get();
        $suppliers = Supplier::where('status', true)->get();

        return view('manager.purchases.summary', compact('items', 'products', 'purchases', 'suppliers'));
    }
}
