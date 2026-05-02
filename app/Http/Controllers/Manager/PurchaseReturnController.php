<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseReturnController extends Controller
{
    public function index()
    {
        $returns = PurchaseReturn::with(['supplier', 'purchase'])->latest()->paginate(20);
        return view('manager.purchase_returns.index', compact('returns'));
    }

    public function create(Request $request)
    {
        $purchase = null;
        if ($request->filled('invoice')) {
            $purchase = Purchase::with(['supplier', 'items.product'])
                ->where('purchase_number', 'like', '%' . $request->invoice . '%')
                ->where('status', 'received')
                ->first();
        }
        return view('manager.purchase_returns.create', compact('purchase'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_id' => 'required|exists:purchases,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'amount'      => 'required|numeric|min:0',
            'reason'      => 'nullable|string',
        ]);

        PurchaseReturn::create([
            'purchase_id'   => $request->purchase_id,
            'supplier_id'   => $request->supplier_id,
            'amount'        => $request->amount,
            'total_product' => $request->total_product ?? 0,
            'status'        => 'pending',
            'reason'        => $request->reason,
        ]);

        return redirect()->route('manager.purchase-returns.index')
                         ->with('success', 'Purchase return created.');
    }

    public function destroy(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->delete();
        return back()->with('success', 'Return deleted.');
    }

    public function approve(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->update(['status' => 'approved']);
        return back()->with('success', 'Return approved.');
    }

    public function reject(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->update(['status' => 'rejected']);
        return back()->with('success', 'Return rejected.');
    }
}
