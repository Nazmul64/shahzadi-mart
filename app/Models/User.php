<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Eager load roles সবসময় — N+1 সমস্যা এড়ানো।
     * roles-এর permissions lazy load করা হয় শুধু hasPermission()-এ।
     */
    protected $with = ['roles'];

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

    // ══════════════════════════════════════════════════════════════
    // Relationships
    // ══════════════════════════════════════════════════════════════

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function directPermissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_user');
    }

    // ══════════════════════════════════════════════════════════════
    // Role Helpers
    // ══════════════════════════════════════════════════════════════

    /**
     * একটি বা একাধিক role slug চেক করো।
     * hasRole('admin') বা hasRole(['admin', 'manager'])
     */
    public function hasRole(string|array $roles): bool
    {
        return $this->roles
            ->whereIn('slug', (array) $roles)
            ->isNotEmpty();
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(['super-admin', 'admin']);
    }

    public function isSubAdmin(): bool
    {
        return $this->hasRole(['super-admin', 'admin', 'sub-admin']);
    }

    public function isManager(): bool
    {
        return $this->hasRole(['super-admin', 'admin', 'manager']);
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
        return $this->hasRole(['super-admin', 'admin', 'manager', 'employee']);
    }

    // পুরানো typo version — backward compatibility
    public function isEmplee(): bool
    {
        return $this->isEmployee();
    }

    /**
     * Admin panel access আছে কিনা
     */
    public function canAccessAdmin(): bool
    {
        return $this->hasRole(['super-admin', 'admin', 'sub-admin', 'manager', 'employee']);
    }

    // ══════════════════════════════════════════════════════════════
    // Permission Helpers
    // ══════════════════════════════════════════════════════════════

    /**
     * Super Admin সব permission পায়।
     * বাকিদের জন্য role → permissions chain চেক করো।
     *
     * Performance: permissions lazy load হয় শুধু এই method call-এ।
     * $this->roles ইতিমধ্যে eager loaded (protected $with)।
     */
    public function hasPermission(string $slug): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->getAllPermissions()->contains($slug);
    }

    /**
     * যেকোনো একটি permission থাকলে true
     */
    public function hasAnyPermission(array $slugs): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $all = $this->getAllPermissions();
        return collect($slugs)->some(fn ($slug) => $all->contains($slug));
    }

    /**
     * সব permission থাকলেই true
     */
    public function hasAllPermissions(array $slugs): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        $all = $this->getAllPermissions();
        return collect($slugs)->every(fn ($slug) => $all->contains($slug));
    }

    /**
     * ইউজারের সব role মিলিয়ে unique permission slug list
     * Cache করা হয় instance lifetime-এ।
     */
    protected ?Collection $_permissionCache = null;

    public function getAllPermissions(): Collection
    {
        if ($this->_permissionCache !== null) {
            return $this->_permissionCache;
        }

        $rolePermissions = $this->roles
            ->loadMissing('permissions')
            ->flatMap(fn ($role) => $role->permissions->pluck('slug'));

        $directPermissions = $this->directPermissions()->pluck('slug');

        $this->_permissionCache = $rolePermissions
            ->merge($directPermissions)
            ->unique()
            ->values();

        return $this->_permissionCache;
    }

    /**
     * Role assign করো — slug দিয়ে (sync: পুরানো মুছে নতুন বসায়)
     */
    public function assignRole(string|array $slugs): void
    {
        $ids = Role::whereIn('slug', (array) $slugs)->pluck('id');
        $this->roles()->sync($ids);
        $this->load('roles'); // fresh load
        $this->_permissionCache = null;
    }

    /**
     * Role add করো (sync না, attach — পুরানো রাখে)
     */
    public function addRole(string $slug): void
    {
        $role = Role::where('slug', $slug)->first();
        if ($role && !$this->hasRole($slug)) {
            $this->roles()->attach($role->id);
            $this->load('roles');
            $this->_permissionCache = null;
        }
    }

    /**
     * Role সরাও
     */
    public function removeRole(string $slug): void
    {
        $role = Role::where('slug', $slug)->first();
        if ($role) {
            $this->roles()->detach($role->id);
            $this->load('roles');
            $this->_permissionCache = null;
        }
    }

    // ══════════════════════════════════════════════════════════════
    // Status Helpers
    // ══════════════════════════════════════════════════════════════

    public function isActive(): bool    { return $this->status === 'active'; }
    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isSuspended(): bool { return $this->status === 'suspended'; }
    public function isInactive(): bool  { return $this->status === 'inactive'; }

    // ══════════════════════════════════════════════════════════════
    // Accessors
    // ══════════════════════════════════════════════════════════════

    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(public_path('uploads/avator/' . $this->photo))) {
            return asset('uploads/avator/' . $this->photo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?? 'U')
             . '&background=1e3a5f&color=fff&size=128';
    }

    public function assignedOrders()
    {
        return $this->hasMany(\App\Models\Order::class, 'assigned_user_id');
    }
}
