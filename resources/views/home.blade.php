@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<section class="py-4">
    <div class="container">
        <div class="hero-banner-v2 rounded-5 shadow-sm d-flex align-items-center justify-content-center"
             style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/lampu3.jpg') }}');">

            <div class="hero-content text-center p-4 w-100">
                <h1 class="fw-bold text-white mb-2 display-5 shadow-text">
                    Solusi Pencahayaan Rumah, Lebih Cepat & Terpercaya
                </h1>
                <p class="text-white mb-4 opacity-90 shadow-text lead">
                    Temukan koleksi lampu berkualitas untuk setiap sudut ruangan Anda.
                </p>

                <div class="search-container position-relative w-100 mx-auto" style="max-width: 650px;">
                    <form action="{{ route('catalog.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control rounded-pill ps-4 py-3 border-0 shadow"
                               placeholder="Cari produk, lampu hias, aksesoris..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 position-absolute end-0 me-1 top-50 translate-middle-y fw-bold shadow-sm">
                            Cari
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Kategori Pilihan - Versi Premium & Modern -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-extrabold display-5 mb-2 text-dark">Kategori Pilihan</h2>
            <p class="text-muted lead">Temukan lampu yang sesuai kebutuhan ruangan Anda</p>
            <div class="category-divider mx-auto mt-3" style="width: 80px; height: 4px; border-radius: 50px; background: linear-gradient(90deg, #0d6efd, #6610f2);"></div>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                        <div class="category-card text-center transition-all hover-lift bg-white rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center justify-content-center">
                            <div class="category-icon-wrapper mb-4 rounded-circle overflow-hidden shadow-sm"
                                 style="width: 140px; height: 140px; background: linear-gradient(135deg, #f8f9ff, #e9ecef); transition: all 0.4s;">
                                <img src="{{ $category->image_url }}"
                                     class="img-fluid p-4"
                                     alt="{{ $category->name }}"
                                     style="object-fit: contain;">
                            </div>
                            <h6 class="fw-bold mb-2 text-dark fs-5">{{ $category->name }}</h6>
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-medium">
                                {{ $category->products_count ?? '0' }} Item
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold display-6 mb-0">Produk Unggulan</h2>
                <p class="text-muted mb-0">Pilihan terbaik untuk kamu</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                Lihat Semua →
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-wrapper transition-all">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100" style="background: linear-gradient(135deg, #fff5e6, #fffaf0);">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4 fs-1">🚚✨</div>
                        <h3 class="fw-bold mb-3">Gratis Ongkir</h3>
                        <h4 class="text-primary fw-bold mb-3">+ Bonus Lampu Hias</h4>
                        <p class="text-muted mb-4">Minimal belanja Rp500rb</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                            Belanja Sekarang
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100" style="background: linear-gradient(135deg, #f3e8ff, #f8f0ff);">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4 fs-1">🌟</div>
                        <h3 class="fw-bold mb-3">Koleksi Baru</h3>
                        <h4 class="text-purple fw-bold mb-3">Diskon 30%</h4>
                        <p class="text-muted mb-4">Lampu modern & luxury ready stock</p>
                        <a href="{{ route('catalog.index', ['sort' => 'newest']) }}" class="btn btn-outline-primary btn-lg rounded-pill px-5">
                            Lihat Koleksi Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Produk Terbaru -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Produk Terbaru</h2>
        <div class="row g-4">
            @foreach($latestProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-wrapper transition-all hover-shadow rounded-3 overflow-hidden bg-white">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
{{-- ================= PRODUK TERBARU ================= --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-6">Produk Terbaru</h2>
            <p class="text-muted">Update produk terbaru setiap hari</p>
        </div>

        <div class="row g-4">
            @foreach($latestProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-wrapper transition-all">
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
    /* Global Transitions */
    .transition-all {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-wrapper:hover {
        transform: translateY(-8px);
    }

    /* Hero Banner (Sesuai Gambar) */
    .hero-banner {
        height: 450px;
        position: relative;
        background-color: #f0f0f0;
    }
    .hero-bg-img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
    }
    .hero-content {
        position: relative;
        z-index: 2;
        height: 100%;
        background: rgba(0, 0, 0, 0.2);
    }
    .shadow-text {
        text-shadow: 2px 2px 8px rgba(0,0,0,0.4);
    }

    /* Banner Navigation */
    .banner-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 3;
        background: white;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        color: #6b46c1;
        transition: 0.3s;
    }
    .arrow-left { left: 25px; }
    .arrow-right { right: 25px; }

    /* Category Styling (Sesuai Gambar) */
    .text-purple { color: #6b46c1; }
    .category-divider {
        width: 50px;
        height: 3px;
        background: #9f7aea;
        border-radius: 10px;
    }
    .category-circle-wrapper {
        width: 120px;
        height: 120px;
        padding: 8px;
        background: #f8f9ff;
        border-radius: 50%;
        transition: transform 0.3s ease;
    }
    .category-circle {
        width: 100%;
        height: 100%;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .category-circle img {
        width: 65%;
        height: 65%;
        object-fit: contain;
    }
    .category-name {
        color: #333;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .category-count {
        background: #f0ecff;
        color: #6b46c1;
        font-size: 0.75rem;
        padding: 3px 12px;
        border-radius: 20px;
        font-weight: bold;
    }

    /* Promo Section */
    .promo-yellow {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #1a202c;
    }
    .promo-blue {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    /* Search Bar */
    .btn-primary {
        background-color: #0d6efd;
        border: none;
    }

    @media (max-width: 768px) {
        .hero-banner { height: 350px; }
        .display-5 { font-size: 1.8rem; }
        .category-circle-wrapper { width: 100px; height: 100px; }
    }
</style>
@endsection
