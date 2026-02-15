<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is apoteker.
     */
    public function isApoteker(): bool
    {
        return $this->role === 'apoteker';
    }

    /**
     * Check if user is pelanggan.
     */
    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }

    /**
     * Get penjualans for this user (if pelanggan).
     */
    public function penjualans(): HasMany
    {
        return $this->hasMany(Penjualan::class, 'user_id', 'id');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Get the route prefix for the user's role.
     */
    public function getRoutePrefix(): string
    {
        return match($this->role) {
            'admin' => 'admin',
            'apoteker' => 'apoteker',
            'pelanggan' => 'pelanggan',
            default => '',
        };
    }
}
