@extends('layouts.app')

@section('content')
<style>
    .order-card { border: none; border-radius: 15px; overflow: hidden; }
    .status-timeline { display: flex; justify-content: space-between; position: relative; margin-bottom: 30px; }
    .status-timeline::before { content: ""; position: absolute; top: 15px; left: 0; right: 0; height: 2px; background: #e9ecef; z-index: 1; }
    .step { position: relative; z-index: 2; background: white; padding: 0 10px; text-align: center; font-size: 0.75rem; font-weight: bold; color: #adb5bd; }
    .step.active { color: var(--bs-primary); }
    .step.active .dot { background: var(--bs-primary); border-color: #cfe2ff; }
    .dot { width: 30px; height: 30px; border-radius: 50%; background: #e9ecef; border: 4px solid white; margin: 0 auto 5px; transition: all 0.3s; }
    .product-img { width: 60px; height: 60px; object-fit: cover; border-radius: 10px; background: #f8f9fa; }
    .invoice-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: #6c757d; font-weight: 700; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            {{-- Breadcrumb / Back Button --}}
            <div class="mb-4">
                <a href="{{ route('orders.index') }}" class="text-decoration-none text-muted small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Pesanan Saya
                </a>
            </div>

            <div class="card order-card shadow-lg">
                {{-- Header Premium --}}
                <div class="card-header bg-dark p-4 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="invoice-label text-white-50">Invoice No.</span>
                            <h2 class="h4 mb-0 text-white fw-bold">#{{ $order->order_number }}</h2>
                        </div>
                        <div class="text-end">
                            <span class="invoice-label text-white-50">Tanggal Transaksi</span>
                            <p class="text-white mb-0 fw-semibold">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    {{-- Visual Progress (Timeline) --}}
                    <div class="status-timeline mb-5">
                        @php
                            $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                            $currentIndex = array_search($order->status, $statuses);
                        @endphp
                        @foreach(['Pesanan Dibuat', 'Diproses', 'Dikirim', 'Diterima'] as $index => $label)
                            <div class="step {{ $currentIndex >= $index ? 'active' : '' }}">
                                <div class="dot shadow-sm"></div>
                                <span class="d-none d-md-block">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="row g-4">
                        {{-- Ringkasan Produk --}}
                        <div class="col-md-7">
                            <h5 class="fw-bold mb-4">Item Pesanan</h5>
                            <div class="list-group list-group-flush">
                                @foreach($order->items as $item)
                                <div class="list-group-item px-0 border-0 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            {{-- Ganti src dengan $item->product->image_url jika ada --}}
                                            <div class="product-img d-flex align-items-center justify-content-center bg-light border text-primary">
                                                <i class="bi bi-box-seam fs-4"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0 fw-bold">{{ $item->product_name }}</h6>
                                            <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->discount_price ?? $item->price, 0, ',', '.') }}</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="fw-bold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Info Pengiriman & Pembayaran --}}
                        <div class="col-md-5">
                            <div class="bg-light rounded-4 p-4 h-100">
                                <h5 class="fw-bold mb-3 small text-uppercase">Detail Pengiriman</h5>
                                <div class="mb-4 small">
                                    <p class="mb-1 fw-bold text-dark"><i class="bi bi-person me-2"></i>{{ $order->shipping_name }}</p>
                                    <p class="mb-1 text-muted"><i class="bi bi-telephone me-2"></i>{{ $order->shipping_phone }}</p>
                                    <p class="mb-0 text-muted"><i class="bi bi-geo-alt me-2"></i>{{ $order->shipping_address }}</p>
                                </div>

                                <hr class="my-4 opacity-10">

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-semibold">Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Ongkos Kirim</span>
                                    <span class="fw-semibold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                    <span class="fw-bold h6 mb-0">Total Bayar</span>
                                    <span class="h4 mb-0 fw-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Area --}}
                @if($order->status === 'pending' && $order->snap_token)
                <div class="card-footer bg-primary-subtle border-0 p-4 text-center">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <h5 class="fw-bold text-primary mb-2">Selesaikan Pembayaran</h5>
                            <p class="small text-primary-emphasis opacity-75 mb-4">Silakan tekan tombol di bawah ini untuk membayar via Midtrans secure payment gateway.</p>
                            <button id="pay-button" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold shadow">
                                <i class="bi bi-shield-lock me-2"></i> Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                @else

                @endif
            </div>

            {{-- Info Tambahan --}}
            <div class="mt-4 text-center">
                <button onclick="window.print()" class="btn btn-link text-muted text-decoration-none small">
                    <i class="bi bi-printer me-1"></i> Cetak Invoice (PDF)
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Script tetap sama namun dengan loading state yang lebih halus --}}
@if($order->snap_token)
@push('scripts')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.addEventListener('click', function () {
                payButton.disabled = true;
                payButton.innerHTML = '<span class="spinner-grow spinner-grow-sm me-2"></span>Menghubungkan...';

                window.snap.pay('{{ $order->snap_token }}', {
                    onSuccess: function (result) { window.location.href = '{{ route("orders.success", $order) }}'; },
                    onPending: function (result) { window.location.href = '{{ route("orders.pending", $order) }}'; },
                    onError: function (result) {
                        alert('Pembayaran gagal!');
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="bi bi-credit-card me-2"></i> Bayar Sekarang';
                    },
                    onClose: function () {
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="bi bi-credit-card me-2"></i> Bayar Sekarang';
                    }
                });
            });
        }
    });
</script>
@endpush
@endif
@endsection
