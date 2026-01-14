{{-- resources/views/admin/reports/sales.blade.php --}}

@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    /* Transisi halus untuk hover kartu */
    .card { transition: all 0.3s ease; border: none !important; border-radius: 15px; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    
    /* Progress bar animation */
    .progress-bar { transition: width 1.5s ease-in-out; }
    
    /* Custom style untuk table */
    .table thead th { background-color: #f8f9fc; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-down">
    <h2 class="h3 mb-0 text-gray-800 fw-bold">Laporan Penjualan</h2>
</div>

<div class="card shadow-sm mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-body">
        <form method="GET" class="row align-items-end g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold small text-muted">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control rounded-3">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold small text-muted">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control rounded-3">
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 rounded-pill transition-all">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
                {{-- Tombol Export --}}
                <a href="{{ route('admin.reports.sales', array_merge(request()->all(), ['export' => 1])) }}" class="btn btn-success px-4 rounded-pill transition-all">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row g-4 mb-4">
    {{-- Total Pendapatan --}}
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="card border-0 shadow-sm border-start border-4 border-success h-100">
            <div class="card-body p-4">
                <div class="text-muted small text-uppercase fw-bold mb-2">Total Pendapatan</div>
                <div class="h3 fw-bold text-dark mb-0">
                     Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}
                </div>
                <small class="text-success fw-bold"><i class="bi bi-arrow-up-short"></i> Periode ini</small>
            </div>
        </div>
    </div>
    {{-- Total Transaksi --}}
    <div class="col-md-4" data-aos="zoom-in" data-aos-delay="300">
        <div class="card border-0 shadow-sm border-start border-4 border-primary h-100">
            <div class="card-body p-4">
                <div class="text-muted small text-uppercase fw-bold mb-2">Total Transaksi</div>
                <div class="h3 fw-bold text-dark mb-0">
                    {{ number_format($summary->total_orders ?? 0) }}
                </div>
                <small class="text-primary fw-bold"><i class="bi bi-check-circle-fill"></i> Order paid</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Sales By Category --}}
    <div class="col-lg-4" data-aos="fade-right" data-aos-delay="400">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title mb-0 fw-bold">Performa Kategori</h5>
            </div>
            <div class="card-body">
                @foreach($byCategory as $cat)
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-medium">{{ $cat->name }}</span>
                            <span class="fw-bold text-dark">Rp {{ number_format($cat->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 8px; background-color: #f1f3f9;">
                            <div class="progress-bar rounded-pill bg-primary" role="progressbar"
                                 style="width: {{ ($cat->total / ($summary->total_revenue ?: 1)) * 100 }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="col-lg-8" data-aos="fade-left" data-aos-delay="500">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-white py-3 border-0">
                 <h5 class="card-title mb-0 fw-bold">Rincian Transaksi</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Order ID</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th class="text-end pe-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-decoration-none text-primary">
                                        #{{ $order->order_number }}
                                    </a>
                                </td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $order->user->name }}</div>
                                    <div class="small text-muted">{{ $order->user->email }}</div>
                                </td>
                                <td class="text-end pe-4 fw-bold text-dark">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                    Tidak ada data penjualan pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white py-3 border-0">
                {{ $orders->appends(request()->all())->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Inisialisasi AOS (Animate On Scroll)
    AOS.init({
        duration: 800,
        once: true,
        easing: 'ease-in-out'
    });
</script>
@endsection