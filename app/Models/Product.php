<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 
        'discount_price', 'stock', 'weight', 'is_active', 'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // ==================== RELATIONSHIPS ====================

    public function category(): BelongsTo { return $this->belongsTo(Category::class); }
    public function images(): HasMany { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
    public function primaryImage(): HasOne { return $this->hasOne(ProductImage::class)->where('is_primary', true); }
    public function firstImage(): HasOne { return $this->hasOne(ProductImage::class)->oldestOfMany('sort_order'); }
    public function orderItems(): HasMany { return $this->hasMany(OrderItem::class); }
    public function cartItems(): HasMany { return $this->hasMany(CartItem::class); }

    // ==================== ACCESSORS ====================

    public function getDisplayPriceAttribute(): float
    {
        if ($this->discount_price > 0 && $this->discount_price < $this->price) {
            return (float) $this->discount_price;
        }
        return (float) $this->price;
    }

    public function getFormattedPriceAttribute(): string { return 'Rp ' . number_format($this->display_price, 0, ',', '.'); }
    public function getFormattedOriginalPriceAttribute(): string { return 'Rp ' . number_format($this->price, 0, ',', '.'); }

    public function getHasDiscountAttribute(): bool
    {
        return $this->discount_price !== null && $this->discount_price > 0 && $this->discount_price < $this->price;
    }

    public function getImageUrlAttribute(): string
    {
        $image = $this->primaryImage ?? $this->firstImage ?? $this->images->first();
        return $image ? $image->image_url : asset('images/no-product-image.jpg');
    }

    public function getIsAvailableAttribute(): bool { return $this->is_active && $this->stock > 0; }

    // ==================== SCOPES (DILENGKAPI) ====================

    public function scopeActive($query) { 
        return $query->where('is_active', true); 
    }

    public function scopeInStock($query) { 
        return $query->where('stock', '>', 0); 
    }

    /**
     * Menambahkan scope featured untuk memperbaiki error di HomeController
     */
    public function scopeFeatured($query) { 
        return $query->where('is_featured', true); 
    }

    // ==================== BOOT & HELPER ====================

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                $product->slug = $slug;
            }
        });
    }
}