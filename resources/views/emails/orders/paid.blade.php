{{-- resources/views/emails/orders/paid.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan #{{ $order->order_number }} - Pembayaran Diterima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .main-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; }
        .btn-primary:hover { background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%); }
        .table th { background: #f8f9fa; font-weight: 600; }
        .status-badge { background: #28a745; color: white; padding: 0.25rem 0.75rem; border-radius: 50px; font-size: 0.875rem; }
        @media (max-width: 576px) {
            .table { font-size: 0.875rem; }
            .btn { width: 100%; }
        }
    </style>
</head>
<body style="margin: 0; padding: 20px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                {{-- Header --}}
                <div class="card border-0 shadow-sm mb-4 main-bg text-white">
                    <div class="card-body text-center py-5">
                        <div class="mb-3">
                            <span class="status-badge d-inline-block">✅ Pembayaran Diterima</span>
                        </div>
                        <h1 class="fw-bold mb-2">Halo, {{ $order->user->name }}!</h1>
                        <p class="lead mb-0">Pesanan <strong>#{{ $order->order_number }}</strong> sedang diproses</p>
                    </div>
                </div>

                {{-- Detail Pesanan --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-receipt me-2"></i>
                            Rincian Pesanan #{{ $order->order_number }}
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        {{-- Tabel Produk --}}
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="col-6">Produk</th>
                                        <th class="col-2 text-center">Qty</th>
                                        <th class="col-4 text-end">Harga Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->product_name }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark px-2 py-1">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="text-end fw-bold text-primary">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    {{-- Total --}}
                                    <tr class="table-success">
                                        <td colspan="2" class="text-end fw-bold">Total Belanja:</td>
                                        <td class="text-end h5 mb-0 text-success">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Info Pengiriman --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="card-title text-muted mb-3">
                            <i class="bi bi-truck me-2"></i>
                            Info Pengiriman
                        </h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>{{ $order->shipping_name }}</strong><br>
                                {{ $order->shipping_phone }}
                            </div>
                            <div class="col-md-6">
                                {{ $order->shipping_address }}
                            </div>
                        </div>
                        <hr class="my-3">
                        <p class="text-muted mb-2">
                            <i class="bi bi-clock-history me-2"></i>
                            Pesanan dibuat: {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                        <span class="badge bg-warning text-dark fs-6">
                            📦 Sedang diproses oleh tim kami
                        </span>
                    </div>
                </div>

                {{-- CTA Button --}}
                <div class="text-center mb-4">
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-lg px-5">
                        <i class="bi bi-eye me-2"></i>
                        Lihat Detail Pesanan
                    </a>
                </div>

                {{-- Footer --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-4">
                        <p class="text-muted mb-2">
                            Ada pertanyaan? Balas email ini atau hubungi
                            <a href="mailto:support@{{ config('app.url', 'store.com') }}" class="text-decoration-none">support@store.com</a>
                        </p>
                        <hr class="my-3 mx-auto" style="width: 200px;">
                        <img src="{{ config('app.logo_url', asset('images/logo.png')) }}"
                             alt="{{ config('app.name') }}"
                             style="max-height: 40px; max-width: 150px;"
                             class="mb-2">
                        <p class="text-muted small mb-0">
                            © {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
