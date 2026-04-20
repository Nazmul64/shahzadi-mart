<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_session_id',
        'user_id',
        'sender_type',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────────────
    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class, 'chat_session_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Helpers ────────────────────────────────────────────────────
    public function getSenderNameAttribute(): string
    {
        if ($this->sender_type === 'admin') {
            return 'Support';
        }
        if ($this->user) {
            return $this->user->name;
        }
        return $this->session->guest_name ?? 'Guest';
    }

    public function isFromAdmin(): bool
    {
        return $this->sender_type === 'admin';
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}
