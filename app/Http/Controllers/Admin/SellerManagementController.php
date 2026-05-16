<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SellerManagementController extends Controller
{
    // Show the create‑seller form
    public function create()
    {
        return view('admin.pages.sellers.create');
    }

    // Store a new seller user and assign the seller role
    public function store(Request $request)
    {
        $request->validate([
            // Basic Info
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|confirmed|min:8',
            'gender'     => 'nullable|string',
            'photo'      => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:5120',

            // Shop Info
            'store_name' => 'required|string|max:255',
            'store_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:5120',
            'store_banner' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:5120',
            'address'    => 'nullable|string',
            'latitude'   => 'nullable|string',
            'longitude'  => 'nullable|string',
            'description' => 'nullable|string',

            // Business Info
            'business_type' => 'nullable|string',
            'trade_license' => 'nullable|string',
            'tin'           => 'nullable|string',
            'categories'    => 'nullable|array',

            // Bank Info
            'bank_name'     => 'nullable|string',
            'branch_name'   => 'nullable|string',
            'account_number' => 'nullable|string',
            'account_holder' => 'nullable|string',
            'mobile_banking_number' => 'nullable|string',
        ]);

        // ---- Image Upload Helper ----
        $uploadImage = function($file, $folder) {
            if (!$file) return null;
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/' . $folder);
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }
            $file->move($destination, $filename);
            return 'uploads/' . $folder . '/' . $filename;
        };

        // ---- Handle Uploads ----
        $photoPath = $uploadImage($request->file('photo'), 'shop');
        $logoPath  = $uploadImage($request->file('store_logo'), 'shop');
        $bannerPath = $uploadImage($request->file('store_banner'), 'shop');

        // ---- Create user ----
        $seller = User::create([
            'name'              => $request->first_name . ' ' . $request->last_name,
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'gender'            => $request->gender,
            'password'          => Hash::make($request->password),
            'photo'             => $photoPath,
            'store_name'        => $request->store_name,
            'store_slug'        => \Illuminate\Support\Str::slug($request->store_name) . '-' . rand(1000, 9999),
            'store_logo'        => $logoPath,
            'store_banner'      => $bannerPath,
            'store_description' => $request->description,
            'latitude'          => $request->latitude,
            'longitude'         => $request->longitude,
            'status'            => 'active',

            // Business & Address JSON
            'address' => [
                'business_type'    => $request->business_type,
                'business_address' => $request->address,
                'trade_license'    => $request->trade_license,
                'tin'              => $request->tin,
                'categories'       => $request->categories,
                'branch_name'      => $request->branch_name,
            ],

            // Bank Information
            'bank_name'             => $request->bank_name,
            'bank_account_name'     => $request->account_holder,
            'bank_account_number'   => $request->account_number,
            'mobile_banking_number' => $request->mobile_banking_number,
            'tax_id'                => $request->tin,
        ]);

        // ---- Assign seller role (slug = 'seller') ----
        $sellerRole = Role::where('slug', 'seller')->firstOrFail();
        $seller->roles()->attach($sellerRole->id);

        return redirect()
            ->route('admin.all_management.index')
            ->with('success', 'Shop and Seller created successfully.');
    }
    // Show all management (list of sellers)
    public function all_management()
    {
        // Get all users with the 'seller' role
        $sellers = User::whereHas('roles', function($q){
            $q->where('slug', 'seller');
        })->latest()->get();

        return view('admin.pages.sellers.all_management', compact('sellers'));
    }

    // Show the edit form for a seller
    public function edit($id)
    {
        $seller = User::findOrFail($id);
        return view('admin.pages.sellers.edit', compact('seller'));
    }

    // Update seller information
    public function update(Request $request, $id)
    {
        $seller = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $id,
            'phone'      => 'required|string|max:20',
            'password'   => 'nullable|confirmed|min:8',
            'store_name' => 'required|string|max:255',
            'photo'      => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:5120',
            'store_logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:5120',
            'store_banner' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:5120',
        ]);

        // ---- Image Upload Helper ----
        $uploadImage = function($file, $folder, $oldPath = null) {
            if (!$file) return $oldPath;
            
            // Delete old file if exists
            if ($oldPath && file_exists(public_path($oldPath))) {
                @unlink(public_path($oldPath));
            }

            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/' . $folder);
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }
            $file->move($destination, $filename);
            return 'uploads/' . $folder . '/' . $filename;
        };

        // ---- Update fields ----
        $seller->name       = $request->first_name . ' ' . $request->last_name;
        $seller->first_name = $request->first_name;
        $seller->last_name  = $request->last_name;
        $seller->email      = $request->email;
        $seller->phone      = $request->phone;
        $seller->gender     = $request->gender;
        
        if ($request->filled('password')) {
            $seller->password = Hash::make($request->password);
        }

        $seller->photo        = $uploadImage($request->file('photo'), 'shop', $seller->photo);
        $seller->store_name   = $request->store_name;
        $seller->store_logo   = $uploadImage($request->file('store_logo'), 'shop', $seller->store_logo);
        $seller->store_banner = $uploadImage($request->file('store_banner'), 'shop', $seller->store_banner);
        $seller->store_description = $request->description;
        $seller->address     = $request->address;
        $seller->latitude    = $request->latitude;
        $seller->longitude   = $request->longitude;
        $seller->status      = $request->status ?? $seller->status;

        $seller->save();

        return redirect()
            ->route('admin.all_management.index')
            ->with('success', 'Shop updated successfully.');
    }

    // Delete a seller
    public function destroy($id)
    {
        $seller = User::findOrFail($id);
        
        // Delete images
        $images = [$seller->photo, $seller->store_logo, $seller->store_banner];
        foreach($images as $img) {
            if ($img && file_exists(public_path($img))) {
                @unlink(public_path($img));
            }
        }

        $seller->delete();

        return redirect()
            ->route('admin.all_management.index')
            ->with('success', 'Shop and Seller deleted successfully.');
    }

    // Toggle seller status
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status == 'active') ? 'inactive' : 'active';
        $user->save();

        return response()->json([
            'status' => 'success',
            'new_status' => $user->status,
            'message' => 'Status updated to ' . ucfirst($user->status)
        ]);
    }
}
?>
