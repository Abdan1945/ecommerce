@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
   <div class="row mb-4">
    <div class="col-md-7">
        <h2 class="h3 fw-bold text-primary mb-1">
            <i class="bi bi-speedometer2 me-2"></i>Dashboard Overview
        </h2>
        <p class="text-muted small">Selamat datang kembali! Berikut adalah ringkasan performa toko Anda hari ini.</p>
    </div>
    <div class="col-md-5 text-md-end">
        <div class="d-inline-flex gap-2">
            {{-- Badge Tanggal --}}
            <div class="badge bg-white text-dark border shadow-sm p-2 px-3 rounded-pill d-flex align-items-center">
                <i class="bi bi-calendar3 me-2 text-primary"></i> {{ date('d F Y') }}
            </div>

            {{-- Tombol Lihat Toko (Bukan Logout) --}}
            {{-- Ini akan membawa Anda ke halaman utama tanpa mengeluarkan akun --}}
            <a href="/" class="btn btn-white border shadow-sm rounded-pill px-3 fw-bold text-dark d-flex align-items-center">
                <i class="bi bi-shop me-2 text-primary"></i> Lihat Toko
            </a>
        </div>
    </div>
</div>

    {{-- STATS CARDS --}}
    <div class="row g-4 mb-4">
        {{-- Card Pendapatan --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-subtle p-3 rounded-3 me-3">
                            <i class="bi bi-currency-dollar text-success fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold uppercase">TOTAL PENDAPATAN</p>
                            <h4 class="mb-0 fw-bold">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="bg-success py-1"></div> {{-- Aksen warna bawah --}}
            </div>
        </div>

        {{-- Card Pesanan --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle p-3 rounded-3 me-3">
                            <i class="bi bi-bag-check text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold uppercase">TOTAL PESANAN</p>
                            <h4 class="mb-0 fw-bold">{{ number_format($stats['total_orders']) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="bg-primary py-1"></div>
            </div>
        </div>

        {{-- Card Pending --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-subtle p-3 rounded-3 me-3">
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold uppercase">PERLU DIPROSES</p>
                            <h4 class="mb-0 fw-bold">{{ $stats['pending_orders'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="bg-warning py-1"></div>
            </div>
        </div>

        {{-- Card Stok --}}
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger-subtle p-3 rounded-3 me-3">
                            <i class="bi bi-exclamation-triangle text-danger fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small fw-bold uppercase">STOK MENIPIS</p>
                            <h4 class="mb-0 fw-bold">{{ $stats['low_stock'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="bg-danger py-1"></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- RECENT ORDERS --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2 text-primary"></i>Pesanan Terbaru</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light border-bottom">
                                <tr>
                                    <th class="ps-4">No. Order</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-end pe-4">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="ps-4">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-decoration-none fw-bold">
                                                #{{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $order->user->name }}</div>
                                            <small class="text-muted" style="font-size: 0.7rem;">{{ $order->user->email }}</small>
                                        </td>
                                        <td class="fw-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            {{-- Menggunakan logika warna yang sama dengan index order --}}
                                            @php
                                                $colors = [
                                                    'pending' => 'warning',
                                                    'processing' => 'info',
                                                    'shipped' => 'primary',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'danger'
                                                ];
                                                $color = $colors[$order->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}-subtle text-{{ $color }} border border-{{ $color }}-subtle px-3 rounded-pill">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">Belum ada pesanan masuk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-lightning-charge me-2 text-primary"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-lg shadow-sm py-3 text-start">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-plus-circle me-3"></i> Tambah Produk</span>
                                <i class="bi bi-chevron-right small opacity-50"></i>
                            </div>
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary btn-lg py-3 text-start">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-grid me-3"></i> Kelola Kategori</span>
                                <i class="bi bi-chevron-right small opacity-50"></i>
                            </div>
                        </a>
                        <a href="{{ route('admin.reports.sales') }}" class="btn btn-outline-dark btn-lg py-3 text-start">
                            <div class="d-flex justify-content-between align-items-center">
                                <span><i class="bi bi-bar-chart-line me-3"></i> Laporan Penjualan</span>
                                <i class="bi bi-chevron-right small opacity-50"></i>
                            </div>
                        </a>
                    </div>
                    <div class="mt-4 p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold mb-2 small text-muted">BANTUAN ADMIN</h6>
                        <p class="small text-muted mb-0">Jika ada kendala pada sistem, hubungi tim IT atau cek dokumentasi penggunaan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
