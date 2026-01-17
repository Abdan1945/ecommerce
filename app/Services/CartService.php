<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): Cart
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        } else {
            $sessionId = Session::getId();
            return Cart::firstOrCreate(['session_id' => $sessionId]);
        }
    }

    public function addProduct(Product $product, int $quantity = 1): void
    {
        $cart = $this->getCart();
        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;
            if ($newQuantity > $product->stock) {
                throw new \Exception("Stok tidak mencukupi. Maksimal: {$product->stock}");
            }
            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            if ($quantity > $product->stock) {
                throw new \Exception("Stok tidak mencukupi.");
            }
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }
        $cart->touch();
    }

    public function updateQuantity(int $itemId, int $quantity): void
    {
        $item = CartItem::findOrFail($itemId);
        if ($quantity > $item->product->stock) {
            throw new \Exception("Stok tidak mencukupi.");
        }

        if ($quantity <= 0) {
            $item->delete();
        } else {
            $item->update(['quantity' => $quantity]);
        }
    }

    public function removeItem(int $itemId): void
    {
        $item = CartItem::findOrFail($itemId);
        $item->delete();
    }

    /**
     * Menghitung Total Harga Keranjang dengan Harga Diskon
     */
    public function getCartTotal(): float
    {
        $cart = $this->getCart();
        return $cart->items->sum(function($item) {
            return $item->product->display_price * $item->quantity;
        });
    }

    public function mergeCartOnLogin(): void
    {
        $sessionId = Session::getId();
        $guestCart = Cart::where('session_id', $sessionId)->with('items')->first();

        if (!$guestCart) return;

        $userCart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        foreach ($guestCart->items as $item) {
            $existingUserItem = $userCart->items()
                ->where('product_id', $item->product_id)
                ->first();

            if ($existingUserItem) {
                $existingUserItem->increment('quantity', $item->quantity);
                $item->delete();
            } else {
                $item->update(['cart_id' => $userCart->id]);
            }
        }
        $guestCart->delete();
    }
}