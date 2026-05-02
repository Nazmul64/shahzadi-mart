<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->paginate(15);
        return view('manager.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('manager.suppliers.create_edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
        ]);

        Supplier::create($request->all());
        return redirect()->route('manager.suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('manager.suppliers.create_edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
        ]);

        $supplier->update($request->all());
        return redirect()->route('manager.suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('manager.suppliers.index')->with('success', 'Supplier deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->status = !$supplier->status;
        $supplier->save();

        return response()->json(['success' => true]);
    }
}
