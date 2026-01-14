@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    :root {
        --primary-color: #0d6efd;
        --soft-bg: #f8f9fa;
    }
    body { background-color: #f4f7f6; overflow-x: hidden; }

    /* Sidebar Styling */
    .filter-card {
        border: none;
        border-radius: 15px;
        position: sticky;
        top: 2rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .filter-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }

    .filter-title {
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #adb5bd;
        margin-bottom: 1.25rem;
    }

    /* Category Radio Customization */
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    .category-label {
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
        display: inline-block;
        width: 100%;
    }
    .category-label:hover { 
        color: var(--primary-color); 
        transform: translateX(5px);
    }

    /* Product Grid Header */
    .catalog-header {
        background: white;
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        border: none;
        transition: all 0.3s ease;
    }

    /* Custom Scrollbar for Filter */
    .filter-form-container {
        max-height: 80vh;
        overflow-y: auto;
        padding-right: 5px;
    }
    .filter-form-container::-webkit-scrollbar { width: 4px; }
    .filter-form-container::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 10px; }

    /* Animasi Tambahan untuk Card Produk */
    .product-item {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .product-item:hover {
        transform: scale(1.03);
    }
</style>

<div class="container py-5">
    <div class="row">
        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3 mb-4" data-aos="fade-right" data-aos-duration="800">
            <div class="card filter-card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('catalog.index') }}" method="GET" id="filter-form">
                        <div class="filter-form-container">
                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-sliders2 me-2 text-primary"></i> Filter
                            </h5>

                            @if(request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            {{-- Filter Kategori --}}
                            <div class="mb-4">
                                <p class="filter-title">Kategori</p>
                                @foreach($categories as $category)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="category"
                                               id="cat-{{ $category->slug }}" value="{{ $category->slug }}"
                                               {{ request('category') == $category->slug ? 'checked' : '' }}
                                               onchange="this.form.submit()">
                                        <label class="form-check-label d-flex justify-content-between w-100 category-label" for="cat-{{ $category->slug }}">
                                            <span>{{ $category->name }}</span>
                                            <span class="text-muted small">({{ $category->products_count }})</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <hr class="my-4 opacity-50">

                            {{-- Filter Harga --}}
                            <div class="mb-4">
                                <p class="filter-title">Rentang Harga</p>
                                <div class="input-group input-group-sm mb-2">
                                    <span class="input-group-text bg-white">Rp</span>
                                    <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price') }}">
                                </div>
                                <div class="input-group input-group-sm mb-3">
                                    <span class="input-group-text bg-white">Rp</span>
                                    <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100 rounded-pill shadow-sm transition-all">
                                    Terapkan Harga
                                </button>
                            </div>

                            {{-- Sedang Diskon --}}
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="on_sale" id="on_sale" value="1"
                                           {{ request('on_sale') ? 'checked' : '' }} onchange="this.form.submit()">
                                    <label class="form-check-label fw-medium" for="on_sale">Diskon Spesial</label>
                                </div>
                            </div>

                            @if(request()->hasAny(['category', 'min_price', 'max_price', 'on_sale']))
                                <a href="{{ route('catalog.index') }}" class="btn btn-link btn-sm text-decoration-none text-danger p-0 mt-2">
                                    <i class="bi bi-x-circle me-1"></i> Bersihkan Semua Filter
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="col-lg-9">
            {{-- Header & Sorting --}}
            <div class="catalog-header shadow-sm d-md-flex justify-content-between align-items-center" data-aos="fade-down" data-aos-duration="800">
                <div class="mb-3 mb-md-0">
                    <h4 class="fw-bold mb-1">
                        @if(request('q'))
                            Pencarian: "{{ request('q') }}"
                        @elseif(request('category'))
                            {{ $categories->firstWhere('slug', request('category'))?->name }}
                        @else
                            Jelajahi Produk
                        @endif
                    </h4>
                    <p class="text-muted small mb-0">Menampilkan {{ $products->count() }} dari {{ $products->total() }} produk</p>
                </div>

                <div class="d-flex align-items-center">
                    <span class="text-muted small me-2 text-nowrap">Urutkan:</span>
                    <select class="form-select form-select-sm border-0 bg-light rounded-pill" style="min-width: 180px;"
                            onchange="window.location.href = this.value">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_asc']) }}" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'name_desc']) }}" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>
                </div>
            </div>

            {{-- Product Grid --}}
            @if($products->count())
                <div class="row g-4">
                    @foreach($products as $index => $product)
                        <div class="col-6 col-md-4 product-item" 
                             data-aos="fade-up" 
                             data-aos-delay="{{ ($index % 3) * 100 }}" 
                             data-aos-duration="600">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 d-flex justify-content-center" data-aos="zoom-in">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="text-center py-5 bg-white rounded-4 shadow-sm" data-aos="zoom-in">
                    <img src="https://illustrations.popsy.co/gray/crashed-error.svg" alt="Empty" style="width: 200px;" class="mb-4">
                    <h5 class="fw-bold">Yah, Produk Tidak Ditemukan</h5>
                    <p class="text-muted">Coba gunakan filter lain atau hapus pencarian Anda.</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary rounded-pill px-4">Lihat Semua Produk</a>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        mirror: false
    });
</script>
@endsection