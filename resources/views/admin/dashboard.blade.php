@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    /* Global Soft Transitions */
    .transition-all { transition: all 0.3s ease; }

    /* Stats Card Enhancement */
    .card-stats { border: none !important; border-radius: 20px; transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .card-stats:hover { transform: translateY(-10px); box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important; }

    .icon-shape { width: 54px; height: 54px; display: flex; align-items: center; justify-content: center; border-radius: 15px; }
    .text-gradient { background: linear-gradient(45deg, #4e73df, #224abe); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

    /* Quick Actions */
    .btn-action { border: 1px solid #f1f3f9; transition: all 0.3s ease; background: #fff; }
    .btn-action:hover { transform: scale(1.02); background-color: #f8faff; color: #4e73df !important; border-color: #4e73df; box-shadow: 0 4px 12px rgba(78, 115, 223, 0.1); }

    /* Custom Scrollbar for Table */
    .table-responsive::-webkit-scrollbar { height: 5px; }
    .table-responsive::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    /* Chart Animation Placeholder */
    #revenueChart { filter: drop-shadow(0px 10px 10px rgba(78, 115, 223, 0.05)); }
</style>

<div class="row mb-4 align-items-center" data-aos="fade-down">
    <div class="col-md-7">
        <h2 class="h3 fw-bold text-dark mb-1"><span class="text-gradient">Dashboard</span> Overview</h2>
        <p class="text-muted mb-0">Halo, <strong>{{ Auth::user()->name }}</strong>. Berikut ringkasan tokomu hari ini.</p>
    </div>
    <div class="col-md-5 text-md-end mt-3 mt-md-0">
        <a href="/" target="_blank" class="btn btn-primary rounded-pill px-4 shadow-lg fw-bold transition-all hover-lift">
            <i class="bi bi-shop me-2"></i> Lihat Toko
        </a>
    </div>
</div>

{{-- STATS CARDS --}}
<div class="row g-4 mb-5">
    @php
        $cards = [
            ['title' => 'PENDAPATAN', 'value' => 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.'), 'icon' => 'bi-wallet2', 'color' => 'primary', 'delay' => '100'],
            ['title' => 'TOTAL ORDER', 'value' => $stats['total_orders'], 'icon' => 'bi-bag-check', 'color' => 'info', 'delay' => '200'],
            ['title' => 'PENDING', 'value' => $stats['pending_orders'], 'icon' => 'bi-hourglass-split', 'color' => 'warning', 'delay' => '300'],
            ['title' => 'STOK TIPIS', 'value' => $stats['low_stock'], 'icon' => 'bi-lightning-charge', 'color' => 'danger', 'delay' => '400'],
        ];
    @endphp
    @foreach($cards as $card)
    <div class="col-sm-6 col-xl-3" data-aos="fade-up" data-aos-delay="{{ $card['delay'] }}">
        <div class="card card-stats shadow-sm h-100">
            <div class="card-body p-4 text-center text-sm-start">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center mb-3">
                    <div class="icon-shape bg-{{ $card['color'] }}-subtle text-{{ $card['color'] }} mb-3 mb-sm-0">
                        <i class="bi {{ $card['icon'] }} fs-3"></i>
                    </div>
                    {{-- Badge persentase dihapus dari sini --}}
                </div>
                <p class="text-muted mb-1 small fw-bold tracking-wider">{{ $card['title'] }}</p>
                <h3 class="mb-0 fw-bold text-dark">{{ $card['value'] }}</h3>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row mb-5">
    {{-- CHART SECTION --}}
    <div class="col-12" data-aos="zoom-in" data-aos-delay="500">
        <div class="card border-0 shadow-sm rounded-4 p-2">
            <div class="card-header bg-white py-4 border-0 d-flex justify-content-between">
                <h5 class="mb-0 fw-bold text-dark">Laporan Penjualan</h5>
                <i class="bi bi-three-dots text-muted"></i>
            </div>
            <div class="card-body">
                <div style="height: 350px;"><canvas id="revenueChart"></canvas></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    {{-- TABLE --}}
    <div class="col-lg-8" data-aos="fade-right" data-aos-delay="600">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
            <div class="card-header bg-white py-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Pesanan Terbaru</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-link text-decoration-none fw-bold text-primary p-0">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small">
                            <th class="ps-4 border-0">NOMOR ORDER</th>
                            <th class="border-0">PEMBELI</th>
                            <th class="border-0">NOMINAL</th>
                            <th class="text-center border-0">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td class="ps-4 py-3"><span class="fw-bold text-dark">#{{ $order->order_number }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle p-2 me-2 text-center" style="width: 32px; height: 32px; line-height: 16px;">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-muted">{{ $order->user->name }}</span>
                                </div>
                            </td>
                            <td class="fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $order->status == 'pending' ? 'bg-warning-subtle text-warning' : 'bg-primary-subtle text-primary' }} rounded-pill px-3 py-2">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ACTIONS --}}
    <div class="col-lg-4" data-aos="fade-left" data-aos-delay="700">
        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            <h5 class="fw-bold mb-4 text-dark">Aksi Cepat</h5>
            <div class="d-grid gap-3">
                <a href="{{ route('admin.products.create') }}" class="btn btn-action text-start p-3 rounded-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-primary-subtle text-primary rounded-3 p-2 me-3"><i class="bi bi-plus-lg"></i></div>
                        <div>
                            <p class="mb-0 fw-bold small">Tambah Produk</p>
                            <small class="text-muted">Input barang baru ke sistem</small>
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.reports.sales') }}" class="btn btn-action text-start p-3 rounded-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-dark-subtle text-dark rounded-3 p-2 me-3"><i class="bi bi-file-earmark-text"></i></div>
                        <div>
                            <p class="mb-0 fw-bold small">Laporan Penjualan</p>
                            <small class="text-muted">Download data transaksi PDF/Excel</small>
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-action text-start p-3 rounded-4">
                    <div class="d-flex align-items-center">
                        <div class="icon-sm bg-info-subtle text-info rounded-3 p-2 me-3"><i class="bi bi-tags"></i></div>
                        <div>
                            <p class="mb-0 fw-bold small">Kelola Kategori</p>
                            <small class="text-muted">Atur grup produk toko</small>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Inisialisasi AOS
    AOS.init({ duration: 800, once: true });

    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('revenueChart');
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        let rawLabels = {!! json_encode($revenueChart->pluck('date')) !!};
        let rawData = {!! json_encode($revenueChart->pluck('total')) !!};

        if (rawLabels.length === 1) {
            const yesterday = new Date(rawLabels[0]);
            yesterday.setDate(yesterday.getDate() - 1);
            rawLabels.unshift(yesterday.toISOString().split('T')[0]);
            rawData.unshift(0);
        }

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(78, 115, 223, 0.2)');
        gradient.addColorStop(1, 'rgba(78, 115, 223, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: rawLabels,
                datasets: [{
                    label: 'Pendapatan',
                    data: rawData,
                    borderColor: '#4e73df',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.45,
                    borderWidth: 4,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4e73df',
                    pointBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        padding: 12,
                        cornerRadius: 12,
                        backgroundColor: '#1a202c',
                        callbacks: {
                            label: function(context) {
                                return ' Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        grid: { color: '#f1f3f9' },
                        ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID'), font: { size: 11 } }
                    },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    });
</script>
@endsection