@extends('layouts.app')

@section('title', 'Keranjang Belanja - Toko Dwaa Lux')

@section('content')
<div class="container py-5 py-lg-6">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-5 fw-bold text-dark">
            <i class="bi bi-cart3 me-3 text-primary"></i>Keranjang Belanja
        </h1>
        <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
        </a>
    </div>

    @if($cart && $cart->items->count())
    <div class="row g-5">
        <!-- Daftar Item Keranjang (Kolom Kiri) -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 45%">Produk</th>
                                    <th class="text-center py-3">Harga</th>
                                    <th class="text-center py-3">Jumlah</th>
                                    <th class="text-end py-3 pe-4">Subtotal</th>
                                    <th class="py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr class="transition-all hover-lift">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->image_url ?? asset('images/placeholder-product.jpg') }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="rounded me-3 shadow-sm" width="80" height="80"
                                                 style="object-fit: cover;">
                                            <div>
                                                <a href="{{ route('catalog.show', $item->product->slug) }}"
                                                   class="fw-medium text-dark text-decoration-none d-block mb-1">
                                                    {{ Str::limit($item->product->name, 60) }}
                                                </a>
                                                <small class="text-muted d-block">
                                                    {{ $item->product->category->name ?? 'Kategori' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-medium">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                   max="{{ $item->product->stock }}"
                                                   class="form-control form-control-sm text-center mx-auto" style="width: 80px;"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="text-end fw-bold">
                                        Rp {{ number_format($item->subtotal ?? $item->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"
                                                    onclick="return confirm('Hapus item ini?')" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Pesanan (Kolom Kanan - Sticky) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-xl rounded-4 overflow-hidden bg-white sticky-top" style="top: 2rem;">
                <div class="card-body p-5">
                    <h2 class="h4 fw-bold mb-4 text-dark">Ringkasan Belanja</h2>

                    <div class="order-summary mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Harga ({{ $cart->items->sum('quantity') }} barang)</span>
                            <span class="fw-medium">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 fw-bold text-dark">Total Pembayaran</span>
                            <span class="h4 fw-bold text-primary">
                                Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-lg">
                        <i class="bi bi-credit-card-2-front me-2"></i>Proses ke Checkout
                    </a>

                    <p class="text-center text-muted small mt-3">
                        <i class="bi bi-lock-fill me-1"></i>Pembayaran aman & terenkripsi
                    </p>
                </div>
            </div>
        </div>
    </div>

    @else
    <!-- Keranjang Kosong -->
    <div class="text-center py-5 my-5">
        <div class="mb-4">
            <i class="bi bi-cart-x display-1 text-muted"></i>
        </div>
        <h4 class="mb-3">Keranjang Belanja Kosong</h4>
        <p class="text-muted mb-4 lead">Yuk mulai tambahkan lampu impianmu ke keranjang!</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg rounded-pill px-5">
            <i class="bi bi-bag-plus me-2"></i>Mulai Belanja
        </a>
    </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .sticky-top { top: 2rem; }
    .transition-all { transition: all 0.35s ease; }
    .hover-lift:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; }
    .btn-primary {
        background: linear-gradient(135deg, #4361ee, #4cc9f0);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(67,97,238,0.3);
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 30px 60px rgba(0,0,0,0.12);
    }
    .text-primary {
        color: #4361ee !important;
    }
</style>
@endsection
