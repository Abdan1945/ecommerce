{{-- ================================================
     FILE: resources/views/home.blade.php
     FUNGSI: Halaman utama website (Beranda)
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- Hero Section --}}
    <section class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-3">
                        Belanja Online Mudah & Terpercaya
                    </h1>
                    <p class="lead mb-4">
                        Temukan berbagai produk berkualitas dengan harga terbaik.
                        Gratis ongkir untuk pembelian pertama!
                    </p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-bag me-2"></i>Mulai Belanja
                    </a>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="{{ asset('images/hero-shopping.svg') }}"
                         alt="Shopping Illustration" class="img-fluid" style="max-height: 400px;" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    {{-- Kategori Populer --}}
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Kategori Populer</h2>
            <div class="row g-4 justify-content-center">
                @forelse($categories ?? [] as $category)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('catalog.index', ['category' => $category->slug]) }}"
                           class="text-decoration-none text-dark">
                            <div class="card border-0 shadow-sm text-center h-100 hover-lift">
                                <div class="card-body py-4">
                                    <img src="{{ $category->image_url ?? asset('images/placeholder-category.jpg') }}"
                                         alt="{{ $category->name }}"
                                         class="rounded-circle mb-3 shadow-sm"
                                         width="80" height="80"
                                         style="object-fit: cover;">
                                    <h6 class="mb-1">{{ $category->name }}</h6>
                                    <small class="text-muted">{{ $category->active_products_count ?? $category->products_count ?? 0 }} produk</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <p class="text-center text-muted">Belum ada kategori.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Produk Unggulan --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Produk Unggulan</h2>
                <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="row g-4">
                @forelse($featuredProducts ?? [] as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @empty
                    <p class="text-muted">Belum ada produk unggulan.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Promo Banner --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card bg-warning text-dark border-0 overflow-hidden">
                        <div class="card-body d-flex flex-column justify-content-center p-5">
                            <h3 class="fw-bold">Flash Sale!</h3>
                            <p class="lead">Diskon hingga 50% untuk produk pilihan</p>
                            <a href="{{ route('catalog.index') }}" class="btn btn-dark mt-3" style="width: fit-content;">
                                Lihat Promo
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-info text-white border-0 overflow-hidden">
                        <div class="card-body d-flex flex-column justify-content-center p-5">
                            <h3 class="fw-bold">Member Baru?</h3>
                            <p class="lead">Dapatkan voucher Rp 50.000 untuk pembelian pertama</p>
                            <a href="{{ route('register') }}" class="btn btn-light mt-3" style="width: fit-content;">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Produk Terbaru --}}
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Produk Terbaru</h2>
            <div class="row g-4">
                @forelse($latestProducts ?? [] as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @empty
                    <p class="text-center text-muted">Belum ada produk terbaru.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
