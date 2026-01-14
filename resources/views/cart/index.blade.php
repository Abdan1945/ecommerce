@extends('layouts.app')

@section('title', 'Keranjang Belanja - Toko Dwaa Lux')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<div class="container py-5 py-lg-6">
    <div class="d-flex justify-content-between align-items-center mb-5" data-aos="fade-down">
        <h1 class="display-5 fw-bold text-dark">
            <i class="bi bi-cart3 me-3 text-primary animate-bounce"></i>Keranjang Belanja
        </h1>
        <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary rounded-pill px-4 transition-all hover-translate-x">
            <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
        </a>
    </div>

    @if($cart && $cart->items->count())
    <div class="row g-5">
        <div class="col-lg-8" data-aos="fade-right" data-aos-delay="200">
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
                                @foreach($cart->items as $index => $item)
                                <tr class="transition-all hover-lift" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="position-relative overflow-hidden rounded shadow-sm me-3" width="80" height="80">
                                                <img src="{{ $item->product->image_url ?? asset('images/placeholder-product.jpg') }}"
                                                     alt="{{ $item->product->name }}"
                                                     class="img-zoom" width="80" height="80"
                                                     style="object-fit: cover;">
                                            </div>
                                            <div>
                                                <a href="{{ route('catalog.show', $item->product->slug) }}"
                                                   class="fw-medium text-dark text-decoration-none d-block mb-1 link-primary-hover">
                                                    {{ Str::limit($item->product->name, 60) }}
                                                </a>
                                                <small class="text-muted d-block">
                                                    {{ $item->product->category->name ?? 'Kategori' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-medium text-nowrap">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                   max="{{ $item->product->stock }}"
                                                   class="form-control form-control-sm text-center mx-auto shadow-none border-soft" style="width: 80px;"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="text-end fw-bold text-nowrap pe-4">
                                        Rp {{ number_format($item->subtotal ?? $item->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle border-0"
                                                    onclick="return confirm('Hapus item ini?')" title="Hapus">
                                                <i class="bi bi-trash fs-5"></i>
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

        <div class="col-lg-4" data-aos="fade-left" data-aos-delay="400">
            <div class="card border-0 shadow-xl rounded-4 overflow-hidden bg-white sticky-top" style="top: 2rem;">
                <div class="card-body p-5">
                    <h2 class="h4 fw-bold mb-4 text-dark d-flex align-items-center">
                        <i class="bi bi-receipt me-2 text-primary"></i>Ringkasan Belanja
                    </h2>

                    <div class="order-summary mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Harga ({{ $cart->items->sum('quantity') }} barang)</span>
                            <span class="fw-medium">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>
                        <hr class="my-3 opacity-10">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 fw-bold text-dark mb-0">Total Pembayaran</span>
                            <span class="h4 fw-bold text-primary mb-0">
                                Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-lg py-3 btn-hover-effect">
                        <i class="bi bi-credit-card-2-front me-2"></i>Proses ke Checkout
                    </a>

                    <p class="text-center text-muted small mt-4 mb-0">
                        <i class="bi bi-lock-fill me-1 text-success"></i>Pembayaran aman & terenkripsi
                    </p>
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="text-center py-5 my-5" data-aos="zoom-in">
        <div class="mb-4 position-relative d-inline-block">
            <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
            <div class="position-absolute top-50 start-50 translate-middle">
                 <i class="bi bi-search display-3 text-primary animate-float"></i>
            </div>
        </div>
        <h4 class="mb-3 fw-bold">Keranjang Belanja Kosong</h4>
        <p class="text-muted mb-4 lead">Yuk mulai tambahkan lampu impianmu ke keranjang!</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg">
            <i class="bi bi-bag-plus me-2"></i>Mulai Belanja
        </a>
    </div>
    @endif
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-quad'
        });
    });
</script>
@endsection

@section('styles')
<style>
    .sticky-top { top: 2rem; z-index: 10; }
    .transition-all { transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); }
    
    /* Efek Hover Baris Tabel */
    .hover-lift:hover { 
        transform: scale(1.01); 
        background-color: #fcfdfe !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05) !important; 
    }

    /* Efek Zoom Gambar */
    .img-zoom { transition: transform 0.5s ease; }
    tr:hover .img-zoom { transform: scale(1.15); }

    /* Button Gradient & Animasi */
    .btn-primary {
        background: linear-gradient(135deg, #4361ee, #4cc9f0);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-hover-effect:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(67,97,238,0.3) !important;
        background: linear-gradient(135deg, #3a56d4, #4361ee);
    }

    .hover-translate-x:hover i {
        transform: translateX(-5px);
        transition: transform 0.3s ease;
    }

    /* Keyframe Animasi */
    @keyframes float {
        0% { transform: translate(-50%, -50%) translateY(0px); }
        50% { transform: translate(-50%, -50%) translateY(-20px); }
        100% { transform: translate(-50%, -50%) translateY(0px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .animate-bounce {
        display: inline-block;
        animation: bounce 2s infinite;
    }

    .border-soft { border: 1px solid #eee; }
    .link-primary-hover:hover { color: #4361ee !important; }
</style>
@endsection