<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    public function index()
    {
        // Only show suppliers added by this specific seller
        $suppliers = User::where('seller_id', auth()->id())
                         ->latest()
                         ->get();
                         
        return view('saller.pages.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('saller.pages.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|string|min:6|confirmed',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,pdf|max:2048',
        ]);

        $photoName = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();
            
            // Photo will be saved in root /uploads/supplier folder as requested
            $path = base_path('uploads/supplier');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            
            $photo->move($path, $photoName);
            $photoName = 'uploads/supplier/' . $photoName;
        }

        User::create([
            'seller_id'  => auth()->id(),
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'name'       => $request->first_name . ' ' . $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'photo'      => $photoName,
            'status'     => 'active',
        ]);

        return redirect()->route('saller.suppliers.index')->with('success', 'Supplier added successfully');
    }

    public function edit($id)
    {
        $supplier = User::where('seller_id', auth()->id())->findOrFail($id);
        return view('saller.pages.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = User::where('seller_id', auth()->id())->findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $id,
            'phone'      => 'required|string|max:20',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,pdf|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Remove old photo from folder
            if ($supplier->photo && File::exists(base_path($supplier->photo))) {
                File::delete(base_path($supplier->photo));
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . Str::random(10) . '.' . $photo->getClientOriginalExtension();
            $path = base_path('uploads/supplier');
            $photo->move($path, $photoName);
            $supplier->photo = 'uploads/supplier/' . $photoName;
        }

        $supplier->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'name'       => $request->first_name . ' ' . $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
        ]);

        if ($request->filled('password')) {
            $supplier->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('saller.suppliers.index')->with('success', 'Supplier updated successfully');
    }

    public function destroy($id)
    {
        $supplier = User::where('seller_id', auth()->id())->findOrFail($id);
        
        // Remove photo before deleting user
        if ($supplier->photo && File::exists(base_path($supplier->photo))) {
            File::delete(base_path($supplier->photo));
        }
        
        $supplier->delete();
        return redirect()->route('saller.suppliers.index')->with('success', 'Supplier deleted successfully');
    }
}
