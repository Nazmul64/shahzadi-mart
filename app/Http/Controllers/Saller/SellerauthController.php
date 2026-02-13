<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SellerauthController extends Controller
{
    // Show login form
    public function saller_login()
    {
        if (Auth::check() && Auth::user()->role === 'seller') {
            return redirect()->route('saller.dashboard');
        }
        return view('saller.seller-auth.login');
    }

    // Show registration form
    public function saller_register()
    {
        if (Auth::check() && Auth::user()->role === 'seller') {
            return redirect()->route('saller.dashboard');
        }
        return view('saller.seller-auth.register');
    }

    // Handle login submission
    public function saller_login_submit(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Attempt login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('rememberMe'))) {
            $user = Auth::user();

            // Check if user is a seller
            if ($user->role !== 'seller') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'You are not authorized as a seller'
                ], 403);
            }

            // Check seller status
            if ($user->status === 'suspended') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been suspended. Please contact support.'
                ], 403);
            }

            if ($user->status === 'inactive') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is inactive. Please contact support.'
                ], 403);
            }

            if ($user->status === 'pending') {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is pending approval. Please wait for admin verification.'
                ], 403);
            }

            // Regenerate session
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login successful! Redirecting...',
                'redirect' => route('saller.dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password. Please try again.'
        ], 401);
    }

    // Handle registration submission
    public function saller_register_submit(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            // Step 1: Basic Information
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',

            // Step 2: Business Details
            'businessType' => 'required|string',
            'businessName' => 'required|string|max:255',
            'businessAddress' => 'required|string',
            'city' => 'required|string|max:255',
            'postalCode' => 'required|string|max:20',

            // Step 3: Store Information
            'storeName' => 'required|string|max:255',
            'storeUrl' => 'required|string|max:255|unique:users,store_slug|regex:/^[a-z0-9-]+$/',
            'storeDescription' => 'required|string|max:500',
            'categories' => 'required|array|min:1',

            // Step 4: Documents & Bank Info
            'bankName' => 'required|string',
            'branchName' => 'required|string|max:255',
            'accountNumber' => 'required|string|max:255',
            'accountHolder' => 'required|string|max:255',
            'terms' => 'accepted',

            // File uploads
            'storeLogo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'storeBanner' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'nationalId' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
            'businessDoc' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Handle file uploads
            $storeLogo = null;
            $storeBanner = null;
            $nationalIdPath = null;
            $businessDocPath = null;

            if ($request->hasFile('storeLogo')) {
                $storeLogo = $this->uploadFile($request->file('storeLogo'), 'sellers/logos');
            }

            if ($request->hasFile('storeBanner')) {
                $storeBanner = $this->uploadFile($request->file('storeBanner'), 'sellers/banners');
            }

            if ($request->hasFile('nationalId')) {
                $nationalIdPath = $this->uploadFile($request->file('nationalId'), 'sellers/documents');
            }

            if ($request->hasFile('businessDoc')) {
                $businessDocPath = $this->uploadFile($request->file('businessDoc'), 'sellers/documents');
            }

            // Create seller user
            $user = User::create([
                'name' => $request->firstName . ' ' . $request->lastName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role' => 'seller',
                'status' => 'pending', // Admin needs to approve

                // Store information
                'store_name' => $request->storeName,
                'store_slug' => $request->storeUrl,
                'store_description' => $request->storeDescription,
                'store_logo' => $storeLogo,

                // Business information (store in address field as JSON)
                'address' => json_encode([
                    'business_type' => $request->businessType,
                    'business_name' => $request->businessName,
                    'business_address' => $request->businessAddress,
                    'city' => $request->city,
                    'postal_code' => $request->postalCode,
                    'trade_license' => $request->tradeLicense,
                    'tin' => $request->tin,
                    'categories' => $request->categories,
                    'store_banner' => $storeBanner,
                    'national_id' => $nationalIdPath,
                    'business_doc' => $businessDocPath,
                    'branch_name' => $request->branchName,
                    'mobile_banking' => $request->mobileBanking,
                    'mobile_banking_number' => $request->mobileBankingNumber,
                    'newsletter' => $request->newsletter ?? false,
                ]),

                // Bank information
                'bank_name' => $request->bankName,
                'bank_account_name' => $request->accountHolder,
                'bank_account_number' => $request->accountNumber,
                'mobile_banking_number' => $request->mobileBankingNumber,
                'tax_id' => $request->tin,
            ]);

            // Send verification email (optional - implement later)
            // Mail::to($user->email)->send(new SellerRegistrationMail($user));

            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Redirecting to login...',
                'redirect' => route('saller.login', ['registered' => 'true']),
                'user' => [
                    'email' => $user->email,
                    'store_name' => $user->store_name,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Handle logout
    public function saller_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('saller.login')->with('success', 'Logged out successfully');
    }

    // Show seller dashboard
    public function saller_dashboard()
    {
        $seller = Auth::user();

        // Get seller statistics
        $stats = [
            'total_products' => 0, // Implement when products table is ready
            'total_orders' => 0,   // Implement when orders table is ready
            'total_sales' => 0,    // Implement when orders table is ready
            'pending_orders' => 0, // Implement when orders table is ready
        ];

        return view('saller.dashboard', compact('seller', 'stats'));
    }

    // Helper function to upload files
    private function uploadFile($file, $folder)
    {
        if ($file) {
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/' . $folder), $filename);
            return 'uploads/' . $folder . '/' . $filename;
        }
        return null;
    }
}
