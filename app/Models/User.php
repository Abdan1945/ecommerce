<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'google_id',
        'phone',
        'address', // ← diperbaiki dari 'addres'
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi ke Cart (1 user punya 1 cart)
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    // Relasi ke Wishlist (many-to-many dengan Product)
    public function wishlists(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wishlists')
                    ->withTimestamps();
    }

    // Alias supaya tidak bentrok (kalau kamu pakai di tempat lain)
    public function wishlistsProducts(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'wishlists')
                    ->withTimestamps();
    }

    // Relasi ke Order
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Helper role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    // Cek apakah product sudah di wishlist user
    public function hasInWishlist(Product $product): bool
    {
        return $this->wishlists()
                    ->where('product_id', $product->id)
                    ->exists();
    }

    /**
     * Accessor untuk URL avatar yang benar.
     * Prioritas: file lokal → Google URL → Gravatar → fallback initials
     */
    public function getAvatarUrlAttribute(): string
    {
        // 1. Avatar upload lokal (disimpan di storage/public)
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        // 2. Avatar dari Google (URL eksternal)
        if ($this->avatar && str_starts_with($this->avatar, 'http')) {
            return $this->avatar;
        }

        // 3. Gravatar berdasarkan email
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=mp&s=200";
    }

    /**
     * Accessor untuk inisial nama (misal untuk avatar berupa huruf)
     * Contoh: "Agung Wahyudi" → "AW"
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', trim($this->name));
        $initials = '';

        foreach ($words as $word) {
            if ($word !== '') {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }

        // Maksimal 2 huruf
        return substr($initials, 0, 2) ?: 'NN'; // fallback kalau nama kosong
    }
}
