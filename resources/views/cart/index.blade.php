@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body d-flex align-items-center justify-content-between py-3 px-4">
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-dark rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali Belanja
            </a>
            <h5 class="mb-0 fw-bold">
                <span class="me-2">🛒</span> Keranjang Saya
            </h5>
        </div>
    </div>

    @if($cart && $cart->items->count())
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-secondary text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 50px;">
                                        <input type="checkbox" class="form-check-input shadow-none" checked>
                                    </th>
                                    <th class="py-3">PRODUK DETAIL</th>
                                    <th class="py-3 text-center">HARGA</th>
                                    <th class="py-3 text-center">JUMLAH</th>
                                    <th class="py-3 text-center">SUBTOTAL</th>
                                    <th class="py-3 text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr>
                                    <td class="ps-4">
                                        <input type="checkbox" class="form-check-input shadow-none" checked>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center py-2">
                                            <img src="{{ $item->product->image_url }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="rounded-3 me-3 border" 
                                                 width="75" height="75" style="object-fit: cover;">
                                            <div>
                                                <h6 class="fw-bold mb-0 text-dark">{{ $item->product->name }}</h6>
                                                <small class="text-muted text-uppercase" style="font-size: 0.7rem;">
                                                    {{ $item->product->category->name ?? 'Produk' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="fw-bold text-dark">
                                            {{ $item->product->formatted_price }}
                                        </div>
                                        @if($item->product->has_discount)
                                            <div class="text-muted small text-decoration-line-through" style="font-size: 0.75rem;">
                                                {{ $item->product->formatted_original_price }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                                   min="1" class="form-control form-control-sm text-center mx-auto shadow-none" 
                                                   style="width: 60px; border-radius: 8px;"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </td>

                                    <td class="text-center fw-bold text-dark">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>

                                    <td class="text-center">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0 shadow-none" onclick="return confirm('Hapus produk?')">
                                                <i class="bi bi-trash3-fill fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold text-uppercase mb-4" style="letter-spacing: 1px;">RINGKASAN PESANAN</h6>
                
                <div class="d-flex justify-content-between mb-3 text-secondary">
                    <span>Total Barang</span>
                    <span class="fw-bold">{{ $cart->items->sum('quantity') }} Unit</span>
                </div>
                
                <div class="d-flex justify-content-between mb-3 text-secondary">
                    <span>Subtotal Harga</span>
                    <span class="fw-bold">Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                </div>
                
                <hr class="my-4 text-muted opacity-25">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Total Tagihan</h5>
                    <h4 class="fw-bold mb-0" style="color: #ffc107;">
                        Rp {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}
                    </h4>
                </div>

                <a href="{{ route('checkout.index') }}" class="btn btn-dark w-100 py-3 rounded-3 fw-bold d-flex justify-content-center align-items-center text-white text-decoration-none shadow-sm checkout-btn">
                    PROSES CHECKOUT <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
        </div>
        <h4 class="fw-bold">Keranjang Anda Kosong</h4>
        <p class="text-muted small">Mari tambahkan beberapa produk ke keranjang Anda!</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-dark px-5 py-2 rounded-pill mt-3">Mulai Belanja</a>
    </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    body { background-color: #f8f9fa; }
    .table thead th { border-bottom: none; background-color: #fcfcfc; }
    .table td { border-color: rgba(0,0,0,0.02); }
    .form-check-input:checked { background-color: #0d6efd; border-color: #0d6efd; }
    .btn-dark { background-color: #1a1a1a; border: none; transition: 0.3s; }
    .btn-dark:hover { background-color: #000; transform: translateY(-2px); }
    .checkout-btn { font-size: 0.9rem; letter-spacing: 0.5px; }
</style>
@endsection