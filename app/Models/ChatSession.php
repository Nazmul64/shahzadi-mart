<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ChatSession extends Model
{
    protected $fillable = [
        'session_uuid',
        'user_id',
        'guest_name',
        'guest_email',
        'status',
        'last_activity_at',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function latestMessage(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->latest()->limit(1);
    }

    // ── Helpers ────────────────────────────────────────────────────
    public static function generateUuid(): string
    {
        return (string) Str::uuid();
    }

    /**
     * Find or create session for logged-in user.
     * Logged-in users always reuse their ACTIVE session (same chat room).
     */
    public static function findOrCreateForUser(int $userId): self
    {
        return self::firstOrCreate(
            ['user_id' => $userId, 'status' => 'active'],
            [
                'session_uuid'      => self::generateUuid(),
                'status'            => 'active',
                'last_activity_at'  => now(),
            ]
        );
    }

    /**
     * Find session by UUID for guests (stored in browser session/cookie).
     */
    public static function findByUuid(string $uuid): ?self
    {
        return self::where('session_uuid', $uuid)->first();
    }

    /**
     * Create a brand-new guest session.
     */
    public static function createGuestSession(string $name, string $email): self
    {
        return self::create([
            'session_uuid'      => self::generateUuid(),
            'guest_name'        => $name,
            'guest_email'       => $email,
            'status'            => 'active',
            'last_activity_at'  => now(),
        ]);
    }

    public function getDisplayNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->guest_name ?? 'Guest';
    }

    public function isGuest(): bool
    {
        return is_null($this->user_id);
    }

    public function unreadCount(): int
    {
        return $this->messages()
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->count();
    }
}
