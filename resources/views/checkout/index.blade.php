@extends('layouts.app')

@section('title', 'Checkout - Toko Dwaa Lux')

@section('content')
<div class="container max-w-7xl mx-auto px-4 py-8 py-lg-10">
    <h1 class="display-5 fw-bold text-center mb-2 text-dark">Checkout Pesanan</h1>
    <p class="text-center text-muted lead mb-5">Lengkapi informasi pengiriman untuk melanjutkan</p>

    <form action="{{ route('checkout.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="row g-lg-5">
            <!-- Kolom Kiri: Form Pengiriman (lebih besar & elegan) -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-body p-5 p-lg-6">
                        <h2 class="h4 fw-bold mb-4 text-dark">Informasi Pengiriman</h2>

                        <div class="row g-4">
                            <!-- Nama Penerima -->
                            <div class="col-12">
                                <label for="name" class="form-label fw-medium text-dark">Nama Penerima</label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg rounded-pill py-3 px-4 @error('name') is-invalid @enderror"
                                       value="{{ auth()->user()->name ?? old('name') }}" required autofocus placeholder="Nama lengkap penerima">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nomor Telepon -->
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-medium text-dark">Nomor Telepon</label>
                                <input type="tel" name="phone" id="phone" class="form-control form-control-lg rounded-pill py-3 px-4 @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}" required placeholder="08xx-xxxx-xxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email (opsional, jika ingin konfirmasi) -->
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-medium text-dark">Email Konfirmasi</label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg rounded-pill py-3 px-4 @error('email') is-invalid @enderror"
                                       value="{{ auth()->user()->email ?? old('email') }}" required placeholder="email@domain.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="col-12">
                                <label for="address" class="form-label fw-medium text-dark">Alamat Lengkap</label>
                                <textarea name="address" id="address" rows="4" class="form-control rounded-4 py-3 px-4 @error('address') is-invalid @enderror"
                                          required placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Catatan Tambahan (opsional) -->
                            <div class="col-12">
                                <label for="notes" class="form-label fw-medium text-dark">Catatan Tambahan (opsional)</label>
                                <textarea name="notes" id="notes" rows="3" class="form-control rounded-4 py-3 px-4"
                                          placeholder="Contoh: Tolong bungkus rapat, panggil sebelum kirim, dll">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Ringkasan Pesanan (sticky) -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white sticky-top" style="top: 2rem;">
                    <div class="card-body p-5">
                        <h2 class="h4 fw-bold mb-4 text-dark">Ringkasan Pesanan</h2>

                        <!-- Daftar Item -->
                        <div class="order-items mb-4" style="max-height: 320px; overflow-y: auto;">
                            @foreach($cart->items as $item)
                                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->product->image_url ?? asset('images/placeholder-product.jpg') }}"
                                             alt="{{ $item->product->name }}" class="rounded me-3" width="60" height="60" style="object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0 fw-medium">{{ $item->product->name }}</h6>
                                            <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                        </div>
                                    </div>
                                    <span class="fw-bold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Total -->
                        <hr class="my-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="h5 fw-bold text-dark">Total Pembayaran</span>
                            <span class="h4 fw-bold text-primary">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                        </div>

                        <!-- Button Submit -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-lg">
                            Buat Pesanan & Bayar Sekarang
                        </button>

                        <p class="text-center text-muted small mt-3">
                            <i class="bi bi-lock-fill me-1"></i> Pembayaran aman & terenkripsi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('styles')
<style>
    .sticky-top { top: 2rem; }
    .form-control-lg.rounded-pill {
        border-radius: 9999px;
        transition: all 0.3s ease;
    }
    .form-control-lg.rounded-pill:focus {
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        border-color: #4361ee;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4361ee, #4cc9f0);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(67,97,238,0.3);
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 30px 60px rgba(0,0,0,0.1);
    }
    .text-primary {
        color: #4361ee !important;
    }
</style>
@endsection
