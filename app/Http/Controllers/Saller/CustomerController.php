<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('seller_id', Auth::id())
            ->whereHas('roles', function($query) {
                $query->where('slug', 'customer');
            })->latest()->get();
            
        return view('saller.pages.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('saller.pages.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|unique:users,phone',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6|confirmed',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'seller_id'  => Auth::id(),
            'name'       => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'status'     => 'active',
        ]);

        // Assign Customer Role
        $user->assignRole('customer');

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/customer');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $image->move($destinationPath, $name);
            $user->photo = 'uploads/customer/' . $name;
            $user->save();
        }

        return redirect()->route('saller.customer.index')->with('success', 'Customer created successfully.');
    }

    public function edit($id)
    {
        $customer = User::where('seller_id', Auth::id())->findOrFail($id);
        return view('saller.pages.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('seller_id', Auth::id())->findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|unique:users,phone,' . $id,
            'email'      => 'required|email|unique:users,email,' . $id,
            'password'   => 'nullable|min:6|confirmed',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->update([
            'name'       => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && file_exists(public_path($user->photo))) {
                @unlink(public_path($user->photo));
            }

            $image = $request->file('photo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/customer');
            $image->move($destinationPath, $name);
            $user->photo = 'uploads/customer/' . $name;
            $user->save();
        }

        return redirect()->route('saller.customer.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::where('seller_id', Auth::id())->findOrFail($id);
        
        // Delete photo if exists
        if ($user->photo && file_exists(public_path($user->photo))) {
            @unlink(public_path($user->photo));
        }

        $user->delete();

        return redirect()->route('saller.customer.index')->with('success', 'Customer deleted successfully.');
    }
}
