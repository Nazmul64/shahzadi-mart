<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SellerAdminChat;
use Illuminate\Support\Facades\Auth;

class SellerChatController extends Controller
{
    // List all sellers who have chatted or all active sellers
    public function index()
    {
        // Only fetch users who are explicitly Sellers
        $sellers = User::whereHas('roles', function($q) {
            $q->where('slug', 'seller');
        })->get();

        return view('admin.pages.seller_chat.index', compact('sellers'));
    }

    // Fetch messages for a specific seller
    public function fetchMessages($seller_id)
    {
        $messages = SellerAdminChat::where('seller_id', $seller_id)
            ->orderBy('created_at', 'asc')
            ->get();
            
        // Mark as read
        SellerAdminChat::where('seller_id', $seller_id)
            ->where('sender', 'seller')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    // Send a message from admin to seller
    public function sendMessage(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg,bmp|max:5120'
        ]);

        if (!$request->message && !$request->hasFile('image')) {
            return response()->json(['error' => 'Message or image is required'], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $destinationPath = public_path('uploads/chat');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            // User requested strictly 'uploads/chat'
            $file->move($destinationPath, $filename);
            $imagePath = 'uploads/chat/' . $filename;
        }

        $chat = SellerAdminChat::create([
            'seller_id' => $request->seller_id,
            'sender' => 'admin',
            'message' => $request->message,
            'image' => $imagePath,
            'is_read' => false
        ]);

        return response()->json([
            'success' => true,
            'chat' => $chat
        ]);
    }
}
