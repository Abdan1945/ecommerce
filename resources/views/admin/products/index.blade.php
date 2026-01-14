@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="fade-in">
    {{-- HEADER PAGE --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-7">
            <h2 class="h3 fw-bold text-primary mb-1">
                <i class="bi bi-box-seam me-2"></i>Manajemen Produk
            </h2>
            <p class="text-muted small">Total <strong>{{ $products->total() }}</strong> produk terdaftar di sistem.</p>
        </div>
        <div class="col-md-5 text-md-end">
            <div class="d-inline-flex gap-2 mb-2">
                {{-- Badge Tanggal --}}
                <div class="badge bg-white text-dark border shadow-sm p-2 px-3 rounded-pill d-flex align-items-center">
                    <i class="bi bi-calendar3 me-2 text-primary"></i> {{ date('d F Y') }}
                </div>

                {{-- Tombol Lihat Toko --}}
                <a href="/" target="_blank" class="btn btn-white border shadow-sm rounded-pill px-3 fw-bold d-flex align-items-center btn-hover-scale">
                    <i class="bi bi-shop me-2 text-primary"></i> Lihat Toko
                </a>
            </div>

            <div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4 fw-bold btn-hover-scale">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Produk Baru
                </a>
            </div>
        </div>
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="card shadow-sm border-0 mb-4 rounded-3 hover-shadow-soft">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0 shadow-none"
                               placeholder="Cari nama produk..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select border-light-subtle shadow-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-light border w-100 fw-semibold text-primary rounded-pill btn-hover-scale">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2 text-center">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-link btn-sm text-muted text-decoration-none">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm border-0 overflow-hidden rounded-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light border-bottom">
                    <tr>
                        <th class="ps-4 py-3" width="80">Gambar</th>
                        <th class="py-3">Info Produk</th>
                        <th class="py-3">Kategori</th>
                        <th class="py-3">Harga</th>
                        <th class="py-3 text-center">Stok</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-end pe-4" width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="product-row">
                        <td class="ps-4">
                            <div class="image-zoom-container">
                                <img src="{{ $product->primaryImage?->image_url ?? asset('img/no-image.png') }}"
                                     class="rounded border shadow-sm" width="60" height="60" style="object-fit: cover;">
                            </div>
                        </td>
                        <td>
                            <div class="fw-bold text-dark mb-0">{{ $product->name }}</div>
                            @if($product->is_featured)
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle smaller-badge">
                                    <i class="bi bi-star-fill me-1"></i>Unggulan
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="text-secondary small fw-medium">{{ $product->category->name }}</span>
                        </td>
                        <td>
                            @if($product->discount_price && $product->discount_price < $product->price)
                                <div class="fw-bold text-primary">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</div>
                                <small class="text-muted text-decoration-line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
                            @else
                                <div class="fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($product->stock <= 5)
                                <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $product->stock }}</span>
                            @else
                                <span class="text-dark fw-medium">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill {{ $product->is_active ? 'status-active' : 'status-inactive' }} px-3">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                        <div class="btn-group shadow-sm rounded-pill border bg-white p-1">
                            {{-- Lihat Detail --}}
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-action btn-view" title="Lihat Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                </svg>
                            </a>

                            {{-- Edit (MENGGUNAKAN ICON BRUSH SVG ANDA) --}}
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-action btn-edit" title="Edit Produk">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brush" viewBox="0 0 16 16">
                                    <path d="M15.825.12a.5.5 0 0 1 .132.584c-1.53 3.43-4.743 8.17-7.095 10.64a6.1 6.1 0 0 1-2.373 1.534c-.018.227-.06.538-.16.868-.201.659-.667 1.479-1.708 1.74a8.1 8.1 0 0 1-3.078.132 4 4 0 0 1-.562-.135 1.4 1.4 0 0 1-.466-.247.7.7 0 0 1-.204-.288.62.62 0 0 1 .004-.443c.095-.245.316-.38.461-.452.394-.197.625-.453.867-.826.095-.144.184-.297.287-.472l.117-.198c.151-.255.326-.54.546-.848.528-.739 1.201-.925 1.746-.896q.19.012.348.048c.062-.172.142-.38.238-.608.261-.619.658-1.419 1.187-2.069 2.176-2.67 6.18-6.206 9.117-8.104a.5.5 0 0 1 .596.04M4.705 11.912a1.2 1.2 0 0 0-.419-.1c-.246-.013-.573.05-.879.479-.197.275-.355.532-.5.777l-.105.177c-.106.181-.213.362-.32.528a3.4 3.4 0 0 1-.76.861c.69.112 1.736.111 2.657-.12.559-.139.843-.569.993-1.06a3 3 0 0 0 .126-.75zm1.44.026c.12-.04.277-.1.458-.183a5.1 5.1 0 0 0 1.535-1.1c1.9-1.996 4.412-5.57 6.052-8.631-2.59 1.927-5.566 4.66-7.302 6.792-.442.543-.795 1.243-1.042 1.826-.121.288-.214.54-.275.72v.001l.575.575zm-4.973 3.04.007-.005zm3.582-3.043.002.001h-.002z"/>
                                </svg>
                            </a>

                            {{-- Hapus --}}
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-action btn-delete" title="Hapus Produk">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                              <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-box-seam display-1 text-light-emphasis mb-3 d-block opacity-25"></i>
                            <h5 class="text-muted">Produk tidak ditemukan</h5>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $products->links('pagination::bootstrap-5') }}
</div>

<style>
    /* Animasi Masuk Halaman */
    .fade-in { animation: fadeIn 0.6s ease-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Hover effects */
    .btn-hover-scale { transition: transform 0.2s, box-shadow 0.2s; }
    .btn-hover-scale:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    
    .product-row { transition: background-color 0.2s; }
    .product-row:hover { background-color: #f8fbff !important; }

    /* Zoom Image */
    .image-zoom-container { overflow: hidden; border-radius: 8px; width: 60px; height: 60px; }
    .image-zoom-container img { transition: transform 0.3s; }
    .product-row:hover .image-zoom-container img { transform: scale(1.15); }

    /* Badges Custom */
    .smaller-badge { font-size: 0.7rem; padding: 3px 8px; font-weight: 600; border-radius: 4px; }
    .status-active { background-color: #e8fadf; color: #28a745; border: 1px solid #d4f2c4; }
    .status-inactive { background-color: #f8f9fa; color: #6c757d; border: 1px solid #e9ecef; }

    /* Tombol Aksi Bulat & Berwarna Soft */
    .btn-action {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px !important;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
    }

    .btn-view { background-color: #e0f7fa; color: #00bcd4; }
    .btn-view:hover { background-color: #00bcd4; color: white; transform: translateY(-3px); }

    .btn-edit { background-color: #fff8e1; color: #ffc107; }
    .btn-edit:hover { background-color: #ffc107; color: white; transform: translateY(-3px); }

    .btn-delete { background-color: #ffebee; color: #ef5350; }
    .btn-delete:hover { background-color: #ef5350; color: white; transform: translateY(-3px); }

    .btn-white { background: #fff; }
</style>
@endsection