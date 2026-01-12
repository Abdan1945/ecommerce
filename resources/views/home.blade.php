@extends('layouts.app')

@section('title', 'Lampu Hias - Beranda')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

{{-- HERO SECTION --}}
<section class="py-4">
    <div class="container" data-aos="fade-down" data-aos-duration="1000">
        <div class="hero-banner-v2 rounded-5 shadow-lg d-flex align-items-center justify-content-center overflow-hidden position-relative"
             style="height: 480px; background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('{{ asset('images/lampu3.jpg') }}'); background-size: cover; background-position: center;">

            <div class="hero-content text-center p-4 w-100 position-relative" style="z-index: 2;">
                <h1 class="fw-bold text-white mb-2 display-5 shadow-text animate__animated animate__fadeInDown">
                    Solusi Pencahayaan Rumah, Lebih Cepat & Terpercaya
                </h1>
                <p class="text-white mb-4 opacity-90 shadow-text lead animate__animated animate__fadeInUp animate__delay-1s">
                    Temukan koleksi lampu berkualitas untuk setiap sudut ruangan Anda.
                </p>

                <div class="search-container position-relative w-100 mx-auto animate__animated animate__zoomIn animate__delay-1s" style="max-width: 650px;">
                    <form action="{{ route('catalog.index') }}" method="GET" class="d-flex glass-search p-2 rounded-pill">
                        <input type="text" name="search" class="form-control rounded-pill ps-4 py-3 border-0 shadow-none search-input"
                               placeholder="Cari produk, lampu hias, aksesoris..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold ms-2 shadow-sm transition-all hover-scale">
                            <i class="bi bi-search me-2"></i>Cari
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- KATEGORI PILIHAN --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-extrabold display-5 mb-2 text-dark">Kategori Pilihan</h2>
            <p class="text-muted lead">Temukan lampu yang sesuai kebutuhan ruangan Anda</p>
            <div class="category-divider mx-auto mt-3"></div>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($categories as $index => $category)
                <div class="col-6 col-md-4 col-lg-3 col-xl-2" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                    <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-decoration-none">
                        <div class="category-card text-center transition-all hover-lift bg-white rounded-4 shadow-sm p-4 h-100 d-flex flex-column align-items-center justify-content-center border">
                            <div class="category-icon-wrapper mb-4 rounded-circle overflow-hidden shadow-sm bg-light-soft transition-all"
                                 style="width: 120px; height: 120px;">
                                <img src="{{ $category->image_url }}"
                                     class="img-fluid p-4 img-hover"
                                     alt="{{ $category->name }}"
                                     style="object-fit: contain;">
                            </div>
                            <h6 class="fw-bold mb-2 text-dark fs-6">{{ $category->name }}</h6>
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

{{-- PRODUK UNGGULAN --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4" data-aos="fade-right">
            <div>
                <h2 class="fw-bold display-6 mb-0">Produk Unggulan</h2>
                <p class="text-muted mb-0">Pilihan terbaik untuk kamu</p>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary rounded-pill px-4 hover-arrow transition-all">
                Lihat Semua <span class="arrow-move">→</span>
            </a>
        </div>

        <div class="row g-4">
            @foreach($featuredProducts as $index => $product)
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="product-wrapper transition-all">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PROMO SECTION --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden h-100 shine-hover" style="background: linear-gradient(135deg, #fff5e6, #fffaf0);">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4 fs-1 floating-animation">🚚✨</div>
                        <h3 class="fw-bold mb-3 text-dark">Gratis Ongkir</h3>
                        <h4 class="text-primary fw-bold mb-3">+ Bonus Lampu Hias</h4>
                        <p class="text-muted mb-4">Minimal belanja Rp500rb</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 pulse-animation">
                            Belanja Sekarang
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="card border-0 shadow-lg rounded-5 overflow-hidden h-100 shine-hover" style="background: linear-gradient(135deg, #f3e8ff, #f8f0ff);">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4 fs-1 floating-animation">🌟</div>
                        <h3 class="fw-bold mb-3 text-dark">Koleksi Baru</h3>
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

{{-- PRODUK TERBARU --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold display-6">Produk Terbaru</h2>
            <p class="text-muted">Update produk terbaru setiap hari</p>
        </div>

        <div class="row g-4">
            @foreach($latestProducts as $index => $product)
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
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
    /* Global Styling */
    .transition-all { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .shadow-text { text-shadow: 2px 2px 8px rgba(0,0,0,0.4); }
    .text-purple { color: #6b46c1; }

    /* Search Bar Glassmorphism */
    .glass-search { background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3); }
    .search-input:focus { transform: scale(1.02); }

    /* Category Animation */
    .category-divider { width: 80px; height: 4px; border-radius: 50px; background: linear-gradient(90deg, #0d6efd, #6610f2); }
    .bg-light-soft { background-color: #f8f9ff; }
    .hover-lift:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
    .hover-lift:hover .img-hover { transform: scale(1.1) rotate(5deg); }

    /* Floating & Pulse Animations */
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .floating-animation { animation: floating 3s ease-in-out infinite; display: inline-block; }

    @keyframes pulse-blue {
        0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(13, 110, 253, 0); }
        100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
    }
    .pulse-animation { animation: pulse-blue 2s infinite; }

    /* Arrow Move Animation */
    .hover-arrow:hover .arrow-move { transform: translateX(8px); display: inline-block; transition: 0.3s; }

    /* Hover Scale */
    .hover-scale:hover { transform: scale(1.05); }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .display-5 { font-size: 1.75rem; }
        .hero-banner-v2 { height: 350px !important; }
    }
</style>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi AOS
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-in-out'
        });
    });
</script>
@endsection
