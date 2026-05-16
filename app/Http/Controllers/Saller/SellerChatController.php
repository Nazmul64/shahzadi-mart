<?php

namespace App\Http\Controllers\Saller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerAdminChat;
use Illuminate\Support\Facades\Auth;

class SellerChatController extends Controller
{
    // View chat interface
    public function index()
    {
        return view('saller.pages.chat.index');
    }

    // Fetch messages for logged-in seller
    public function fetchMessages()
    {
        $seller_id = Auth::id(); // Assuming seller is logged in as User
        
        $messages = SellerAdminChat::where('seller_id', $seller_id)
            ->orderBy('created_at', 'asc')
            ->get();
            
        // Mark as read
        SellerAdminChat::where('seller_id', $seller_id)
            ->where('sender', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json($messages);
    }

    // Send a message from seller to admin
    public function sendMessage(Request $request)
    {
        $request->validate([
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

        $seller_id = Auth::id();

        $chat = SellerAdminChat::create([
            'seller_id' => $seller_id,
            'sender' => 'seller',
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
