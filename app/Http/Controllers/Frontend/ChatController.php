<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    // 1. Start / resume a chat session
    // POST /chat/start  →  chat.start
    // ══════════════════════════════════════════════════════════════
    public function start(Request $request): JsonResponse
    {
        // ── Logged-in user ────────────────────────────────────────
        if (Auth::check()) {
            $session = ChatSession::where('user_id', Auth::id())
                ->whereIn('status', ['active', 'pending'])
                ->latest()
                ->first();

            if (! $session) {
                $session = ChatSession::create([
                    'user_id'          => Auth::id(),
                    'session_uuid'     => Str::uuid(),
                    'status'           => 'active',
                    'last_activity_at' => now(),
                ]);
            }

            return response()->json([
                'success'      => true,
                'session_uuid' => $session->session_uuid,
                'messages'     => $this->loadMessages($session),
                'display_name' => Auth::user()->name,
            ]);
        }

        // ── Guest: resume by UUID ─────────────────────────────────
        $uuid = $request->input('session_uuid') ?? session('chat_uuid');
        if ($uuid) {
            $session = ChatSession::where('session_uuid', $uuid)
                ->whereIn('status', ['active', 'pending'])
                ->first();

            if ($session) {
                session(['chat_uuid' => $session->session_uuid]);
                return response()->json([
                    'success'      => true,
                    'session_uuid' => $session->session_uuid,
                    'messages'     => $this->loadMessages($session),
                    'display_name' => $session->guest_name ?? 'Guest',
                ]);
            }
        }

        // ── Guest: new session ────────────────────────────────────
        $request->validate([
            'guest_name'  => 'required|string|max:100',
            'guest_email' => 'required|email|max:191',
        ]);

        $session = ChatSession::create([
            'user_id'          => null,
            'session_uuid'     => Str::uuid(),
            'guest_name'       => $request->guest_name,
            'guest_email'      => $request->guest_email,
            'status'           => 'active',
            'last_activity_at' => now(),
        ]);

        session(['chat_uuid' => $session->session_uuid]);

        return response()->json([
            'success'      => true,
            'session_uuid' => $session->session_uuid,
            'messages'     => [],
            'display_name' => $session->guest_name,
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    // 2. Send a message
    // POST /chat/send  →  chat.send
    // ══════════════════════════════════════════════════════════════
    public function send(Request $request): JsonResponse
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $session = $this->resolveSession($request);
        if (! $session) {
            return response()->json(['success' => false, 'error' => 'Session not found.'], 404);
        }

        $msg = ChatMessage::create([
            'chat_session_id' => $session->id,
            'user_id'         => Auth::id(),
            'sender_type'     => Auth::check() ? 'user' : 'guest',
            'message'         => $request->message,
            'is_read'         => false,
        ]);

        $session->update(['last_activity_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => $this->formatMsg($msg, $session),
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    // 3. Poll for new messages
    // GET /chat/messages?after_id=XX  →  chat.messages
    // ══════════════════════════════════════════════════════════════
    public function getMessages(Request $request): JsonResponse
    {
        $session = $this->resolveSession($request);
        if (! $session) {
            return response()->json(['success' => false, 'error' => 'Session not found.'], 404);
        }

        $afterId = (int) $request->input('after_id', 0);

        $msgs = $session->messages()
            ->with('user')
            ->when($afterId > 0, fn($q) => $q->where('id', '>', $afterId))
            ->orderBy('id', 'asc')
            ->get();

        // Mark admin messages as read by the user
        $session->messages()
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success'  => true,
            'messages' => $msgs->map(fn($m) => $this->formatMsg($m, $session))->values(),
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    // 4. Close session
    // POST /chat/close  →  chat.close
    // ══════════════════════════════════════════════════════════════
    public function close(Request $request): JsonResponse
    {
        $session = $this->resolveSession($request);
        if ($session) {
            $session->update(['status' => 'closed']);
        }
        session()->forget('chat_uuid');

        return response()->json(['success' => true]);
    }

    // ── Private helpers ────────────────────────────────────────────

    private function resolveSession(Request $request): ?ChatSession
    {
        if (Auth::check()) {
            return ChatSession::where('user_id', Auth::id())
                ->whereIn('status', ['active', 'pending'])
                ->latest()
                ->first();
        }

        $uuid = $request->input('session_uuid')
             ?? $request->input('uuid')
             ?? session('chat_uuid');

        if (! $uuid) return null;

        return ChatSession::where('session_uuid', $uuid)->first();
    }

    private function loadMessages(ChatSession $session): array
    {
        return $session->messages()
            ->with('user')
            ->orderBy('id', 'asc')
            ->get()
            ->map(fn($m) => $this->formatMsg($m, $session))
            ->toArray();
    }

    private function formatMsg(ChatMessage $m, ChatSession $session): array
    {
        if ($m->sender_type === 'admin') {
            $senderName = 'Support';
            $isOwn      = false;
        } elseif ($m->sender_type === 'user') {
            $senderName = $m->user?->name ?? 'User';
            $isOwn      = true;
        } else {
            // guest
            $senderName = $session->guest_name ?? 'Guest';
            $isOwn      = true;
        }

        return [
            'id'          => $m->id,
            'message'     => $m->message,
            'sender_type' => $m->sender_type,
            'sender_name' => $senderName,
            'is_own'      => $isOwn,
            'time'        => $m->created_at->format('g:i A'),
            'is_read'     => (bool) $m->is_read,
        ];
    }
}
