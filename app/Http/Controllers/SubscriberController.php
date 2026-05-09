<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    /**
     * Store a new subscriber (Frontend AJAX).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ], [
            'email.unique' => 'আপনি ইতিমধ্যে সাবস্ক্রাইব করেছেন!',
            'email.email'  => 'একটি সঠিক ইমেইল প্রদান করুন।',
            'email.required' => 'ইমেইল আবশ্যক।'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        Subscriber::create(['email' => $request->email]);

        return response()->json([
            'success' => true,
            'message' => 'সাবস্ক্রাইব করার জন্য ধন্যবাদ!'
        ]);
    }

    /**
     * List all subscribers (Admin).
     */
    public function index()
    {
        $subscribers = Subscriber::latest()->paginate(20);
        return view('admin.subscribers.index', compact('subscribers'));
    }

    /**
     * Remove a subscriber (Admin).
     */
    public function destroy($id)
    {
        $subscriber = Subscriber::findOrFail($id);
        $subscriber->delete();

        return redirect()->back()->with('success', 'সাবস্ক্রাইবার সফলভাবে মুছে ফেলা হয়েছে।');
    }
}
