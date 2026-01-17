<?php
// app/Services/OrderService.php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * Membuat Order baru dari Keranjang belanja.
     */
    public function createOrder(User $user, array $shippingData): Order
    {
        // 1. Ambil Keranjang User
        $cart = $user->cart;

        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception("Keranjang belanja kosong.");
        }

        return DB::transaction(function () use ($user, $cart, $shippingData) {

            // A. VALIDASI STOK & HITUNG TOTAL
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok produk {$item->product->name} tidak mencukupi.");
                }
                
                // PERBAIKAN: Gunakan display_price agar totalnya Rp 250.000
                $totalAmount += $item->product->display_price * $item->quantity;
            }

            // B. BUAT HEADER ORDER
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'shipping_name' => $shippingData['name'],
                'shipping_address' => $shippingData['address'],
                'shipping_phone' => $shippingData['phone'],
                'total_amount' => $totalAmount, // Total yang sudah diskon
            ]);

            // C. PINDAHKAN ITEMS
            foreach ($cart->items as $item) {
                // Ambil harga saat ini (Snapshot harga promo)
                $currentPrice = $item->product->display_price;

                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    
                    // PERBAIKAN: Simpan harga diskon ke historical data pesanan
                    'price' => $currentPrice, 
                    'quantity' => $item->quantity,
                    'subtotal' => $currentPrice * $item->quantity,
                ]);

                // D. KURANGI STOK (ATOMIC)
                $item->product->decrement('stock', $item->quantity);
            }

            // E. BERSIHKAN KERANJANG
            $cart->items()->delete();

            return $order;
        });
    }
}