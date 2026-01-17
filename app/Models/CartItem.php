<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ==================== ACCESSORS ====================

    /**
     * Menghitung subtotal item menggunakan display_price dari Model Product.
     * Ini akan otomatis mengambil Rp 250.000 jika ada diskon, 
     * atau Rp 750.000 jika tidak ada diskon.
     */
    public function getSubtotalAttribute()
    {
        // Menggunakan logic display_price yang sudah kita buat di Model Product
        return $this->product->display_price * $this->quantity;
    }

    /**
     * Alias untuk subtotal jika controller Anda memanggil total_price
     */
    public function getTotalPriceAttribute()
    {
        return $this->subtotal;
    }

    public function getTotalWeightAttribute()
    {
        return $this->product->weight * $this->quantity;
    }

    // ==================== BOOT ====================
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cartItem) {
            $cartItem->validateStock();
        });

        static::updating(function ($cartItem) {
            $cartItem->validateStock();
        });
    }

    /**
     * Helper untuk validasi stok agar kode lebih rapi
     */
    protected function validateStock()
    {
        if (!$this->relationLoaded('product')) {
            $this->load('product');
        }

        if (!$this->product) {
            throw new \Exception('Produk tidak ditemukan.');
        }

        if ($this->quantity > $this->product->stock) {
            throw new \Exception('Stok produk tidak mencukupi.');
        }
    }
}