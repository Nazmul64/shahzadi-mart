<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('admin.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:customers,email',
            'phone'       => 'required|string|max:20',
            'address'     => 'required|string|max:500',
            'city'        => 'nullable|string|max:100',
            'state'       => 'nullable|string|max:100',
            'country'     => 'nullable|string|max:100',
            'fax'         => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'password'    => 'required|string|min:6',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image    = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            // Save ONLY inside uploads/customer — no storage, no public
            $destination = base_path('uploads/customer');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $image->move($destination, $filename);
            $imagePath = 'uploads/customer/' . $filename;
        }

        Customer::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'city'        => $request->city,
            'state'       => $request->state,
            'country'     => $request->country,
            'fax'         => $request->fax,
            'postal_code' => $request->postal_code,
            'password'    => Hash::make($request->password),
            'image'       => $imagePath,
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:customers,email,' . $id,
            'phone'       => 'required|string|max:20',
            'address'     => 'required|string|max:500',
            'city'        => 'nullable|string|max:100',
            'state'       => 'nullable|string|max:100',
            'country'     => 'nullable|string|max:100',
            'fax'         => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:20',
            'password'    => 'nullable|string|min:6',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address', 'city', 'state', 'country', 'fax', 'postal_code']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($customer->image && file_exists(base_path($customer->image))) {
                unlink(base_path($customer->image));
            }

            $image    = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $destination = base_path('uploads/customer');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $image->move($destination, $filename);
            $data['image'] = 'uploads/customer/' . $filename;
        }

        $customer->update($data);

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        if ($customer->image && file_exists(base_path($customer->image))) {
            unlink(base_path($customer->image));
        }

        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Customer deleted successfully.');
    }

    /**
     * Toggle block/unblock status.
     */
    public function updateStatus(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->status = ($customer->status === 'active') ? 'blocked' : 'active';
        $customer->save();

        return redirect()->back()->with('success', 'Customer status updated.');
    }

    /**
     * Make customer a vendor.
     */
    public function makeVendor(Request $request, string $id)
    {
        $request->validate([
            'shop_name'           => 'required|string|max:255',
            'owner_name'          => 'required|string|max:255',
            'shop_number'         => 'required|string|max:50',
            'shop_address'        => 'required|string|max:500',
            'registration_number' => 'nullable|string|max:100',
            'shop_details'        => 'required|string',
            'plan'                => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->is_vendor = true;
        $customer->save();

        // TODO: Store vendor-specific details in a vendors table if needed.

        return redirect()->back()->with('success', 'Customer promoted to vendor successfully.');
    }
}
