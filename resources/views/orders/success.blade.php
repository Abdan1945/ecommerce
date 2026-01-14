@extends('layouts.app')

@section('content')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .success-card {
        border: none;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .icon-wrapper {
        position: relative;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .order-number {
        background: #f8f9fa;
        padding: 10px 20px;
        border-radius: 50px;
        display: inline-block;
        color: #6c757d;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .btn-custom {
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(13, 110, 253, 0.2);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 text-center">
            <div class="card success-card p-4 p-md-5" data-aos="zoom-in" data-aos-duration="800">
                
                <div class="icon-wrapper mb-4">
                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                    <lottie-player src="https://assets10.lottiefiles.com/packages/lf20_kzfpndct.json" 
                        background="transparent" speed="1" style="width: 250px; height: 250px;" autoplay></lottie-player>
                </div>

                <h1 class="display-6 fw-bold text-dark mb-2">Pembayaran Berhasil!</h1>
                <p class="text-muted fs-5 mb-4">Hore! Pesanan Anda telah kami terima dan sedang disiapkan oleh tim kami.</p>
                
                <div class="mb-4">
                    <span class="order-number">ID Pesanan: #{{ $order->order_number ?? $order->id }}</span>
                </div>

                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-custom shadow-sm">
                        <i class="bi bi-receipt me-2"></i>Lihat Detail Pesanan
                    </a>
                    <a href="/" class="btn btn-outline-secondary btn-custom">
                        Kembali Berbelanja
                    </a>
                </div>
            </div>

            
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Inisialisasi AOS (Animasi Muncul)
    AOS.init();

    // Jalankan Confetti saat halaman dimuat
    window.onload = function() {
        var duration = 3 * 1000;
        var end = Date.now() + duration;

        (function frame() {
            confetti({
                particleCount: 3,
                angle: 60,
                spread: 55,
                origin: { x: 0 },
                colors: ['#0d6efd', '#198754', '#ffc107']
            });
            confetti({
                particleCount: 3,
                angle: 120,
                spread: 55,
                origin: { x: 1 },
                colors: ['#0d6efd', '#198754', '#ffc107']
            });

            if (Date.now() < end) {
                requestAnimationFrame(frame);
            }
        }());

        // Confetti meledak di tengah
        confetti({
            particleCount: 150,
            spread: 70,
            origin: { y: 0.6 }
        });
    };
</script>
@endsection