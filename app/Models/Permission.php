<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'slug', 'group', 'description'];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    // ── Static Helpers ─────────────────────────────────────────────────────────

    /**
     * Database থেকে সব distinct group নাম আনে — hardcode নয়
     */
    public static function getAllGroups()
    {
        return self::whereNotNull('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group');
    }
}
