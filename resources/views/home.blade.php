@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

{{-- ================= HERO ================= --}}
<section class="hero-gradient text-white py-5 position-relative overflow-hidden">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6 z-2">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2">
                    🔥 Promo Spesial Hari Ini
                </span>

                <h1 class="display-3 fw-bold mb-3 hero-title">
                    Belanja Online <br> Murah Meriah
                </h1>

                <p class="lead mb-4">
                    Temukan berbagai produk berkualitas dengan harga terbaik.
                    Gratis ongkir untuk pembelian pertama!
                </p>

                <a href="{{ route('catalog.index') }}" class="btn btn-light btn-lg shadow">
                    <i class="bi bi-bag me-2"></i> Mulai Belanja
                </a>
            </div>

            <div class="col-lg-6 d-none d-lg-flex justify-content-center z-2">
                <img src="{{ asset('images/store.jpg') }}" alt="Shopping" class="img-fluid"
                    style="max-height: 400px;">
            </div>
        </div>
    </div>

    {{-- overlay --}}
    <div class="hero-overlay"></div>
</section>

{{-- ================= KATEGORI ================= --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Kategori Populer</h2>
            <p class="text-muted">Pilih kategori favoritmu</p>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                       class="text-decoration-none text-dark">
                        <div class="card category-card border-0 text-center h-100">
                            <div class="card-body">
                                <img src="{{ $category->image_url }}"
                                     class="rounded-circle mb-3"
                                     width="90" height="90"
                                     style="object-fit: cover;">
                                <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                                <small class="text-muted">
                                    {{ $category->products_count }} produk
                                </small>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Produk Unggulan</h2>
                <small class="text-muted">Pilihan terbaik untuk kamu</small>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary">
                Lihat Semua →
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= PROMO ================= --}}
<section class="py-5 promo-section text-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="promo-card promo-yellow">
                    <h3 class="fw-bold">⚡ Flash Sale</h3>
                    <p>Diskon sampai 50% hari ini</p>
                    <a href="#" class="btn btn-dark">Lihat Promo</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="promo-card promo-blue">
                    <h3 class="fw-bold">🎁 Member Baru</h3>
                    <p>Dapatkan voucher Rp 50.000</p>
                    <a href="{{ route('register') }}" class="btn btn-light">
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
            <h2 class="fw-bold">Produk Terbaru</h2>
            <p class="text-muted">Update produk terbaru</p>
        </div>

        <div class="row g-4">
            @foreach($latestProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
