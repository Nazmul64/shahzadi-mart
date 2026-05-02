<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AdminChatController extends Controller
{
    // ══════════════════════════════════════════════════════════════
    // 1. All sessions list page
    // GET /chat  →  admin.chat.index
    // ══════════════════════════════════════════════════════════════
    public function index()
    {
        $sessions = ChatSession::with([
                'user',
                'messages' => fn($q) => $q->latest()->limit(1)
            ])
            ->orderByDesc('last_activity_at')
            ->paginate(30);

        $sessions->each(fn($s) => $s->unread_count = $s->messages()
            ->whereIn('sender_type', ['user', 'guest'])
            ->where('is_read', false)->count());

        $viewPrefix = request()->routeIs('manager.*') ? 'manager.chat' : (request()->routeIs('emplee.*') ? 'emplee.chat' : 'admin.chat');
        return view("{$viewPrefix}.index", compact('sessions'));
    }

    // ══════════════════════════════════════════════════════════════
    // 2. Open a specific chat (two-panel: sidebar + chat window)
    // GET /chat/{chatSession}  →  admin.chat.show
    // ══════════════════════════════════════════════════════════════
    public function show(ChatSession $chatSession)
    {
        // All sessions for the left sidebar
        $allSessions = ChatSession::with([
                'user',
                'messages' => fn($q) => $q->latest()->limit(1)
            ])
            ->orderByDesc('last_activity_at')
            ->get();

        // Attach unread counts
        $allSessions->each(fn($s) => $s->unread_count = $s->messages()
            ->whereIn('sender_type', ['user', 'guest'])
            ->where('is_read', false)->count());

        // Current session's messages
        $messages = $chatSession->messages()
            ->with('user')
            ->orderBy('id', 'asc')
            ->get();

        // Mark user/guest messages as read when admin opens
        $chatSession->messages()
            ->whereIn('sender_type', ['user', 'guest'])
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $viewPrefix = request()->routeIs('manager.*') ? 'manager.chat' : (request()->routeIs('emplee.*') ? 'emplee.chat' : 'admin.chat');
        return view("{$viewPrefix}.show", compact('chatSession', 'messages', 'allSessions'));
    }

    // ══════════════════════════════════════════════════════════════
    // 3. Admin sends reply
    // POST /chat/{chatSession}/reply  →  admin.chat.reply
    // ══════════════════════════════════════════════════════════════
    public function reply(Request $request, ChatSession $chatSession): JsonResponse
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $msg = ChatMessage::create([
            'chat_session_id' => $chatSession->id,
            'user_id'         => null,
            'sender_type'     => 'admin',
            'message'         => $request->message,
            'is_read'         => false,
        ]);

        $chatSession->update(['last_activity_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => $this->formatMsg($msg, $chatSession),
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    // 4. Poll new messages
    // GET /chat/{chatSession}/messages?after_id=XX  →  admin.chat.messages
    // ══════════════════════════════════════════════════════════════
    public function getMessages(Request $request, ChatSession $chatSession): JsonResponse
    {
        $afterId = (int) $request->input('after_id', 0);

        $msgs = $chatSession->messages()
            ->with('user')
            ->when($afterId > 0, fn($q) => $q->where('id', '>', $afterId))
            ->orderBy('id', 'asc')
            ->get();

        // Auto-mark incoming as read
        $chatSession->messages()
            ->whereIn('sender_type', ['user', 'guest'])
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success'  => true,
            'messages' => $msgs->map(fn($m) => $this->formatMsg($m, $chatSession))->values(),
        ]);
    }

    // ══════════════════════════════════════════════════════════════
    // 5. Global unread count (sidebar badge)
    // GET /chat/unread-count  →  admin.chat.unread
    // ══════════════════════════════════════════════════════════════
    public function unreadCount(): JsonResponse
    {
        $count = ChatMessage::whereIn('sender_type', ['user', 'guest'])
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    // ══════════════════════════════════════════════════════════════
    // 6. Close a session
    // POST /chat/{chatSession}/close  →  admin.chat.close
    // ══════════════════════════════════════════════════════════════
    public function close(ChatSession $chatSession): JsonResponse
    {
        $chatSession->update(['status' => 'closed']);
        return response()->json(['success' => true]);
    }

    // ── Private formatter ──────────────────────────────────────────
    private function formatMsg(ChatMessage $m, ChatSession $session): array
    {
        return [
            'id'          => $m->id,
            'message'     => $m->message,
            'sender_type' => $m->sender_type,
            'sender_name' => $m->sender_type === 'admin'
                ? 'Support'
                : ($m->user?->name ?? $session->guest_name ?? 'Guest'),
            'is_own'      => $m->sender_type === 'admin',
            'time'        => $m->created_at->format('g:i A'),
            'is_read'     => (bool) $m->is_read,
        ];
    }
}
