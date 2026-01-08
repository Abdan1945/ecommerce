@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- ================= HERO ================= --}}
<section class="hero-gradient text-white py-5 position-relative overflow-hidden">
    <div class="container position-relative z-2">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6">
                <span class="badge bg-warning text-dark mb-3 px-4 py-2 rounded-pill fw-bold">
                    🔥 Promo Spesial Hari Ini
                </span>

                <h1 class="display-3 fw-bold mb-4 hero-title">
                    Belanja Online <br>
                    <span class="text-warning">Murah Meriah</span>
                </h1>

                <p class="lead mb-5 opacity-90">
                    Temukan ribuan produk berkualitas dengan harga terbaik.<br>
                    Gratis ongkir untuk pembelian pertama!
                </p>

                <a href="{{ route('catalog.index') }}" class="btn btn-light btn-lg shadow-lg rounded-pill px-5 py-3 fw-bold">
                    <i class="bi bi-bag me-2"></i> Mulai Belanja
                </a>
            </div>

            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/gambar Toko lampu .png') }}" alt="Shopping"
                     class="img-fluid rounded-3 shadow-lg" style="max-height: 450px; object-fit: cover;">
            </div>
        </div>
    </div>

    <!-- Overlay untuk efek gradient lebih dalam -->
    <div class="hero-overlay"></div>
</section>

{{-- ================= KATEGORI ================= --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5">Kategori Populer</h2>
            <p class="text-muted lead">Pilih kategori favoritmu</p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                       class="text-decoration-none text-dark">
                        <div class="card category-card border-0 shadow-sm text-center h-100 transition-all">
                            <div class="card-body py-5">
                                <div class="rounded-circle overflow-hidden mx-auto mb-3 shadow"
                                     style="width: 100px; height: 100px;">
                                    <img src="{{ $category->image_url }}"
                                         class="w-100 h-100 object-fit-cover" alt="{{ $category->name }}">
                                </div>
                                <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                                <small class="text-muted">{{ $category->products_count }} produk</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= PRODUK UNGGULAN ================= --}}
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold display-5 mb-0">Produk Unggulan</h2>
                <small class="text-muted lead">Pilihan terbaik untuk kamu</small>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                Lihat Semua →
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="transition-all">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= PROMO ================= --}}
<section class="py-5 promo-section text-white position-relative overflow-hidden">
    <div class="container position-relative z-2">
        <div class="row g-5">
            <div class="col-md-6">
                <div class="promo-card promo-yellow rounded-4 shadow-lg p-5 text-center text-md-start transition-all">
                    <h3 class="fw-bold display-6 mb-3">⚡ Flash Sale</h3>
                    <p class="lead mb-4 opacity-90">Diskon sampai <strong class="display-5">50%</strong> hari ini saja!</p>
                    <a href="#" class="btn btn-dark btn-lg rounded-pill px-5 shadow">
                        Lihat Promo
                    </a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="promo-card promo-blue rounded-4 shadow-lg p-5 text-center text-md-start transition-all">
                    <h3 class="fw-bold display-6 mb-3">🎁 Member Baru</h3>
                    <p class="lead mb-4 opacity-90">Dapatkan voucher <strong class="text-warning display-5">Rp 50.000</strong></p>
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-5 shadow">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= PRODUK TERBARU ================= --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-5">Produk Terbaru</h2>
            <p class="text-muted lead">Update produk terbaru setiap hari</p>
        </div>

        <div class="row g-4">
            @foreach($latestProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="transition-all">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@section('styles')
<style>
    /* Efek transisi halus untuk semua kartu */
    .transition-all {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-all:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    /* Hero improvements */
    .hero-gradient {
        background: linear-gradient(135deg, #6b46c1, #d53f8c, #f56565);
    }
    .hero-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.2);
    }
    .hero-title {
        line-height: 1.2;
    }

    /* Category card */
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    /* Promo section */
    .promo-section {
        background: linear-gradient(135deg, #4299e1, #9f7aea);
    }
    .promo-yellow {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #1a202c;
    }
    .promo-blue {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    /* Responsif gambar hero di mobile */
    @media (max-width: 991px) {
        .min-vh-75 {
            min-height: 70vh !important;
        }
    }
</style>
@endsection
