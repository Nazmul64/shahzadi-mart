<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomerSellerChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class CustomerSellerChatController extends Controller
{
    private function getSessionUuid()
    {
        $uuid = Cookie::get('chat_session_uuid');
        if (!$uuid) {
            $uuid = (string) Str::uuid();
            Cookie::queue('chat_session_uuid', $uuid, 60 * 24 * 365); // 1 year
        }
        return $uuid;
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'product_id' => 'nullable|exists:products,id'
        ]);

        $customerId = Auth::check() ? Auth::id() : null;
        $sessionUuid = $this->getSessionUuid();

        $chat = CustomerSellerChat::create([
            'customer_id' => $customerId,
            'session_uuid' => $sessionUuid,
            'seller_id' => $request->seller_id,
            'product_id' => $request->product_id,
            'sender_type' => 'customer',
            'message' => $request->message,
        ]);

        // Eager load customer for the response
        if ($chat->customer) {
            $chat->load('customer');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Message sent successfully',
            'data' => $chat
        ]);
    }

    public function getMessages($sellerId)
    {
        $customerId = Auth::check() ? Auth::id() : null;
        $sessionUuid = $this->getSessionUuid();

        $messages = CustomerSellerChat::with('customer', 'seller')
            ->where(function($q) use ($sellerId, $customerId, $sessionUuid) {
                $q->where('seller_id', $sellerId);
                
                $q->where(function($subQ) use ($customerId, $sessionUuid) {
                    if ($customerId) {
                        $subQ->where('customer_id', $customerId)
                             ->orWhere('session_uuid', $sessionUuid);
                    } else {
                        $subQ->where('session_uuid', $sessionUuid);
                    }
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $messages,
            'current_user_id' => $customerId,
            'session_uuid' => $sessionUuid
        ]);
    }
}
