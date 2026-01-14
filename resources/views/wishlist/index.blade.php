{{-- resources/views/wishlist/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    /* Efek Header */
    .wishlist-title i {
        display: inline-block;
        animation: heartBeat 1.5s infinite;
        color: #ff4d6d;
    }

    @keyframes heartBeat {
        0% { transform: scale(1); }
        14% { transform: scale(1.3); }
        28% { transform: scale(1); }
        42% { transform: scale(1.3); }
        70% { transform: scale(1); }
    }

    /* Hover Card Effect */
    .wishlist-item {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .wishlist-item:hover {
        transform: translateY(-10px);
    }

    /* Empty State Animation */
    .empty-wishlist-icon {
        display: inline-block;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .btn-shop {
        background: linear-gradient(45deg, #ff4d6d, #ff758c);
        border: none;
        transition: all 0.3s;
    }
    .btn-shop:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(255, 77, 109, 0.3);
        background: linear-gradient(45deg, #ff758c, #ff4d6d);
    }
</style>

<div class="container py-5">
    <div class="d-flex align-items-center mb-5" data-aos="fade-right">
        <h1 class="h3 fw-bold mb-0 wishlist-title">
            <i class="bi bi-heart-fill me-2"></i> Wishlist Saya
        </h1>
        <span class="badge bg-light text-dark border ms-3 rounded-pill px-3 py-2">
            {{ $products->count() }} Produk
        </span>
    </div>

    @if($products->count())
        <div class="row row-cols-2 row-cols-md-4 g-4">
            @foreach($products as $index => $product)
                <div class="col wishlist-item" 
                     data-aos="fade-up" 
                     data-aos-delay="{{ $index * 100 }}">
                     <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center" data-aos="fade-up">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-5 px-4 bg-white rounded-4 shadow-sm border" 
             data-aos="zoom-in" 
             data-aos-duration="800">
            <div class="mb-4 empty-wishlist-icon">
                <div class="position-relative d-inline-block">
                    <i class="bi bi-heart text-light" style="font-size: 6rem; -webkit-text-stroke: 2px #dee2e6;"></i>
                    <i class="bi bi-search text-primary position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm" style="font-size: 1.5rem;"></i>
                </div>
            </div>
            <h3 class="h4 fw-bold text-dark">Wah, Wishlist-mu Masih Kosong</h3>
            <p class="text-muted mt-2 mb-4 mx-auto" style="max-width: 400px;">
                Sepertinya kamu belum menemukan barang impian. Yuk, keliling katalog kami dan simpan produk yang kamu suka!
            </p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg btn-shop rounded-pill px-5 fw-bold shadow-sm">
                <i class="bi bi-bag-heart me-2"></i> Mulai Cari Produk
            </a>
        </div>
    @endif
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-out-back'
        });
    });
</script>
@endsection