@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

{{-- 
    =========================================
    HERO SECTION
    =========================================
--}}
<section class="py-4 py-lg-5">
    <div class="container">
        <div class="hero-banner-v2 rounded-5 shadow-lg d-flex align-items-center justify-content-center position-relative overflow-hidden"
             data-aos="zoom-in" 
             data-aos-duration="1200"
             style="background-image: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.6)), url('{{ asset('images/lampu3.jpg') }}');">
            
            <div class="hero-content text-center p-4 w-100 z-1">
                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 mb-3 fw-bold animate__animated animate__fadeInDown">
                    <i class="bi bi-stars me-1"></i> KOLEKSI TERBARU 2026
                </span>

                <h1 class="fw-extrabold text-white mb-3 display-4 shadow-text ls-tight" data-aos="fade-up" data-aos-delay="200">
                    Sempurnakan Hunian Dengan <br>
                    <span class="text-warning">Cahaya Estetik</span>
                </h1>

                <p class="text-white-50 mb-5 max-w-600 mx-auto lead shadow-text d-none d-md-block" data-aos="fade-up" data-aos-delay="400">
                    Koleksi lampu eksklusif dari desainer ternama untuk menciptakan atmosfer ruangan yang hangat, nyaman, dan mewah.
                </p>

                {{-- SEARCH BAR --}}
                <div class="search-container position-relative w-100 mx-auto" style="max-width: 700px;" data-aos="fade-up" data-aos-delay="600">
                    <form action="{{ route('catalog.index') }}" method="GET" class="glass-search p-2 rounded-pill shadow-lg bg-white">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0 ps-4">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control bg-transparent border-0 text-dark ps-2 py-3 no-focus"
                                   placeholder="Cari lampu gantung, LED, atau lampu hias..." 
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn btn-warning rounded-pill px-4 px-md-5 py-2 fw-bold shadow-sm transition-all hover-scale">
                                Cari Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- KATEGORI --}}
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

{{-- LATEST PRODUCTS --}}
<section class="py-5 bg-light position-relative">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center mb-5" data-aos="fade-up">
            <div>
                <h2 class="fw-extrabold h1 mb-0">Koleksi Terbaru</h2>
                <div class="h-pill bg-primary mt-2"></div>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-link text-primary text-decoration-none fw-bold">
                Lihat Semua <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>

        <div class="row g-4">
            @foreach($latestProducts as $index => $product)
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ 100 * ($index % 4) }}">
                    <div class="product-modern-card h-100">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PROMO/GARANSI --}}
<section class="py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-10 col-xl-8" data-aos="fade-right">
                <div class="promo-card-v2 p-4 p-md-5 rounded-5 shadow-lg overflow-hidden h-100 position-relative" 
                     style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                    
                    <div class="content position-relative z-1">
                        <span class="text-warning fw-bold tracking-widest d-block mb-3">TRUSTED SERVICE</span>
                        <h2 class="display-5 fw-bold text-white mb-4 ls-tight">
                            Garansi Kepuasan <br>
                            <span class="text-primary">Tanpa Syarat</span>
                        </h2>

                        <div class="row g-3 mb-5">
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center text-white">
                                    <div class="icon-sm bg-primary rounded-circle me-3">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <span class="fw-medium">100% Produk Original</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="d-flex align-items-center text-white">
                                    <div class="icon-sm bg-primary rounded-circle me-3">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <span class="fw-medium">Packing Kayu Aman</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 hover-lift shadow">
                            Jelajahi Katalog
                        </a>
                    </div>

                    <div class="floating-icon bi bi-lightbulb position-absolute opacity-10" style="right: -20px; bottom: -20px; font-size: 10rem; color: #fff; transform: rotate(15deg);"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic'
        });
    });
</script>
@endsection

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary-font: 'Plus Jakarta Sans', sans-serif;
    }

    body {
        font-family: var(--primary-font);
        overflow-x: hidden;
    }

    .fw-extrabold { font-weight: 800; }
    .ls-tight { letter-spacing: -1.5px; }
    .tracking-widest { letter-spacing: 2px; }
    .shadow-text { text-shadow: 0 2px 10px rgba(0,0,0,0.3); }

    .hero-banner-v2 {
        min-height: 550px;
        background-size: cover;
        background-position: center;
    }

    .glass-search {
        background: #ffffff !important;
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
    }

    .no-focus:focus {
        box-shadow: none;
        outline: none;
    }

    .product-modern-card { 
        transition: all 0.4s ease; 
    }
    
    .product-modern-card:hover { 
        transform: translateY(-10px); 
    }

    .icon-sm {
        width: 40px; 
        height: 40px;
        display: flex; 
        align-items: center; 
        justify-content: center;
    }

    .h-pill { width: 60px; height: 6px; border-radius: 50px; }
    
    .hover-lift { transition: transform 0.3s ease; }
    .hover-lift:hover { transform: translateY(-5px); }
    
    .hover-scale { transition: transform 0.3s ease; }
    .hover-scale:hover { transform: scale(1.05); }

    @media (max-width: 768px) {
        .hero-banner-v2 { min-height: 400px; padding: 40px 0; }
        .display-4 { font-size: 2.2rem; }
    }
</style>
@endsection