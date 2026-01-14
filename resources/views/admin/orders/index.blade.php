@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    /* Efek halus saat baris tabel di-hover */
    .table-hover tbody tr {
        transition: background-color 0.3s ease;
    }
    /* Animasi muncul untuk card */
    .fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container-fluid fade-in-up">
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Daftar Pesanan</h2>
    </div>

    {{-- Alert Notifikasi Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            {{-- Filter Status Menggunakan Nav Pills --}}
            <ul class="nav nav-pills card-header-pills">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">Semua</a>
                </li>
                @php
                    $statuses = [
                        'pending' => 'Pending',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'delivered' => 'Sampai',
                        'cancelled' => 'Batal'
                    ];
                @endphp
                @foreach($statuses as $key => $label)
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == $key ? 'active' : '' }}" 
                       href="{{ route('admin.orders.index', ['status' => $key]) }}">
                       {{ $label }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No. Order</th>
                            <th>Customer</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr class="animate__animated animate__fadeIn">
                                <td class="ps-4">
                                    <span class="fw-bold text-primary">#{{ $order->order_number }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $order->user->name }}</div>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </td>
                                <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="fw-bold">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $badgeColor = [
                                            'pending' => 'bg-warning text-dark',
                                            'processing' => 'bg-info text-dark',
                                            'shipped' => 'bg-primary text-white',
                                            'delivered' => 'bg-success text-white',
                                            'cancelled' => 'bg-danger text-white'
                                        ];
                                    @endphp
                                    <span class="badge {{ $badgeColor[$order->status] ?? 'bg-secondary' }} px-3 py-2">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- Tombol Lihat Detail --}}
                                        <a href="{{ route('admin.orders.show', $order) }}" 
                                           class="btn btn-sm btn-outline-primary shadow-sm">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>

                                        {{-- Form Hapus Pesanan --}}
                                        <form action="{{ route('admin.orders.destroy', $order) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('PENTING: Menghapus pesanan #{{ $order->order_number }} akan mengembalikan stok barang ke sistem otomatis jika status belum BATAL. Lanjutkan?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm">
                                                <i class="fas fa-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3"></i>
                                        <p class="mb-0">Tidak ada data pesanan yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection