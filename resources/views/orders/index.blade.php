@extends('layouts.app')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    /* Desain Badge Kustom */
    .status-badge {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Hover effect pada baris tabel */
    .table-order tbody tr {
        transition: all 0.3s ease;
    }
    .table-order tbody tr:hover {
        background-color: rgba(37, 117, 252, 0.03);
        transform: scale(1.01);
        z-index: 1;
        position: relative;
    }

    /* Card Styling */
    .order-main-card {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .empty-state-icon {
        font-size: 5rem;
        background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        opacity: 0.5;
        animation: float 3s ease-in-out infinite;
    }

    /* Animasi Mengapung untuk Icon Kosong */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }

    /* Custom Button Group Hover */
    .btn-group .btn {
        transition: all 0.2s;
    }
    .btn-group .btn:hover {
        background-color: #f1f4f9;
        letter-spacing: 0.5px;
    }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down" data-aos-duration="800">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Riwayat Pesanan</h1>
            <p class="text-muted small mb-0">Pantau status dan detail belanja Anda di sini.</p>
        </div>
        <div class="bg-primary-subtle rounded-circle p-3" data-aos="zoom-in" data-aos-delay="200">
            <i class="bi bi-bag-check text-primary fs-3"></i>
        </div>
    </div>

    <div class="card order-main-card shadow-sm border-0" data-aos="fade-up" data-aos-duration="1000">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-order align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Informasi Order</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Tanggal</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-center">Status</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase">Total Pembayaran</th>
                            <th class="py-3 text-muted small fw-bold text-uppercase text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                        <tr data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}" data-aos-offset="0">
                            <td class="ps-4 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary-subtle text-primary rounded-3 p-2 me-3 d-none d-sm-block">
                                        <i class="bi bi-hash fs-5"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block mb-0">{{ $order->order_number }}</span>
                                        <small class="text-muted">{{ $order->items->count() }} Produk</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="text-dark fw-medium">{{ $order->created_at->format('d M Y') }}</span>
                                <div class="text-muted x-small" style="font-size: 0.75rem;">{{ $order->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td class="py-4 text-center">
                                @php
                                    $statusConfig = [
                                        'pending'    => ['bg' => 'bg-warning-subtle', 'text' => 'text-warning', 'label' => 'Menunggu', 'icon' => 'bi-clock'],
                                        'processing' => ['bg' => 'bg-info-subtle', 'text' => 'text-info', 'label' => 'Diproses', 'icon' => 'bi-gear'],
                                        'shipped'    => ['bg' => 'bg-primary-subtle', 'text' => 'text-primary', 'label' => 'Dikirim', 'icon' => 'bi-truck'],
                                        'delivered'  => ['bg' => 'bg-success-subtle', 'text' => 'text-success', 'label' => 'Selesai', 'icon' => 'bi-check-circle'],
                                        'cancelled'  => ['bg' => 'bg-danger-subtle', 'text' => 'text-danger', 'label' => 'Dibatalkan', 'icon' => 'bi-x-circle'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? ['bg' => 'bg-secondary-subtle', 'text' => 'text-secondary', 'label' => $order->status, 'icon' => 'bi-question-circle'];
                                @endphp
                                <span class="status-badge {{ $config['bg'] }} {{ $config['text'] }} d-inline-flex align-items-center">
                                    <i class="bi {{ $config['icon'] }} me-1"></i> {{ $config['label'] }}
                                </span>
                            </td>
                            <td class="py-4">
                                <span class="fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-end pe-4 py-4">
                                <div class="btn-group shadow-sm rounded-pill overflow-hidden border">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-white btn-sm px-3 fw-bold border-end">
                                        Detail
                                    </a>
                                    @if($order->status == 'pending')
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-sm px-3 fw-bold">
                                            Bayar
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div data-aos="zoom-in">
                                    <i class="bi bi-cart-x empty-state-icon d-block mb-3"></i>
                                    <h5 class="fw-bold text-dark">Belum ada pesanan</h5>
                                    <p class="text-muted small">Sepertinya Anda belum melakukan transaksi apapun.</p>
                                    <a href="/" class="btn btn-primary rounded-pill px-4 mt-2 shadow-sm">Mulai Belanja</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($orders->hasPages())
        <div class="card-footer bg-white py-3 border-0">
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-in-out'
        });
    });
</script>
@endsection