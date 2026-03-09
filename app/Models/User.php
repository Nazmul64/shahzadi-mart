<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'phone', 'photo', 'address',
        'store_name', 'store_slug', 'store_description', 'store_logo',
        'tax_id', 'bank_name', 'bank_account_name', 'bank_account_number',
        'mobile_banking_number', 'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $appends = ['photo_url'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    // ── Role Check Helpers ─────────────────────────────────────────────────────

    public function hasRole(string $slug): bool
    {
        return $this->roles->contains('slug', $slug);
    }

    public function hasAnyRole(array $slugs): bool
    {
        return $this->roles->whereIn('slug', $slugs)->isNotEmpty();
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasAnyRole(['super-admin', 'admin', 'manager', 'sub-admin']);
    }

    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    public function isSeller(): bool
    {
        return $this->hasRole('seller');
    }

    public function isCustomer(): bool
    {
        return $this->hasRole('customer');
    }

    public function isEmployee(): bool
    {
        return $this->hasRole('employee');
    }

    // isEmplee() — typo version, purano code na vange
    public function isEmplee(): bool
    {
        return $this->isEmployee();
    }

    // ── Permission Helpers ─────────────────────────────────────────────────────

    public function hasPermission(string $slug): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->getAllPermissions()->contains($slug);
    }

    public function hasAnyPermission(array $slugs): bool
    {
        $all = $this->getAllPermissions();
        foreach ($slugs as $slug) {
            if ($all->contains($slug)) {
                return true;
            }
        }
        return false;
    }

    public function getAllPermissions()
    {
        return $this->roles
            ->flatMap(fn ($role) => $role->permissions->pluck('slug'))
            ->unique();
    }

    // ── Status Helpers ─────────────────────────────────────────────────────────

    public function isActive(): bool    { return $this->status === 'active'; }
    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isSuspended(): bool { return $this->status === 'suspended'; }

    // ── Accessors ──────────────────────────────────────────────────────────────

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(public_path('uploads/avator/' . $this->photo))) {
            return asset('uploads/avator/' . $this->photo);
        }

        $name = urlencode($this->name ?? 'U');
        return "https://ui-avatars.com/api/?name={$name}&background=1e3a5f&color=fff&size=128";
    }
}
