{{-- ================================================
FILE: resources/views/partials/footer.blade.php
KEREN & MODERN SIAP COPY-PASTE
================================================ --}}
<footer class="footer-modern position-relative overflow-hidden">
    <!-- Background gradient & pattern -->
    <div class="footer-bg"></div>

    <div class="container position-relative z-2">
        <!-- Main Footer -->
        <div class="row g-4 py-5">
            <!-- Brand -->
            <div class="col-lg-4 col-md-6">
                <div class="brand-section mb-4">
                    <h3 class="brand-logo mb-3">
                        <i class="bi bi-bag-heart-fill text-warning me-3"></i>
                        DwaaLux
                    </h3>
                    <p class="text-light opacity-90 lh-lg">
                        Toko online #1 di Indonesia. Kualitas terjamin,
                        harga murah, pengiriman cepat ke seluruh wilayah.
                    </p>
                    <!-- Social Media -->
                    <div class="social-links mt-4">
                        <a href="#" class="social-btn facebook" title="Facebook" aria-label="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-btn instagram" title="Instagram" aria-label="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-btn tiktok" title="TikTok" aria-label="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="#" class="social-btn whatsapp" title="WhatsApp" aria-label="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-title mb-4">Menu Utama</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('catalog.index') }}">Katalog Produk</a></li>
                    <li><a href="#">Promo & Diskon</a></li>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>

            <!-- Shop -->
            <div class="col-lg-2 col-md-6">
                <h6 class="footer-title mb-4">Belanja</h6>
                <ul class="footer-links">
                    <li><a href="#">Keranjang</a></li>
                    <li><a href="#">Checkout</a></li>
                    <li><a href="#">Pelacakan Pesanan</a></li>
                    <li><a href="#">Pengembalian</a></li>
                </ul>
            </div>

            <!-- Support -->
            <div class="col-lg-4 col-md-6">
                <h6 class="footer-title mb-4">Bantuan</h6>
                <ul class="footer-links">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Panduan Belanja</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                </ul>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="contact-row row g-4 mb-5 pb-4">
            <div class="col-md-6">
                <div class="contact-item">
                    <i class="bi bi-geo-alt-fill text-warning fs-4"></i>
                    <div>
                        <h6 class="mb-1">Alamat</h6>
                        <p class="mb-0">Jl. Raya Jakarta No. 123, Bandung 40123</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact-item">
                    <i class="bi bi-telephone-fill text-warning fs-4"></i>
                    <div>
                        <h6 class="mb-1">Telepon</h6>
                        <p class="mb-0">0812-3456-7890</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="contact-item">
                    <i class="bi bi-envelope-fill text-warning fs-4"></i>
                    <div>
                        <h6 class="mb-1">Email</h6>
                        <p class="mb-0">hello@dwaalux.com</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment & Copyright -->
        <div class="bottom-bar">
            <hr class="border-secondary border-2 opacity-25 mb-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <p class="text-light opacity-75 mb-0 small">
                        © {{ date('Y') }} <strong>DwaaLux</strong>. Semua hak dilindungi.
                    </p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <!-- Payment Methods -->
                    <div class="payment-methods">
                        <img src="{{ asset('images/gopay.jpg') }}" alt="GoPay" height="32" class="me-2">
                        <img src="{{ asset('images/shopeepay.jpg') }}" alt="ShopeePay" height="32" class="me-2">
                        <img src="{{ asset('images/dana.webp') }}" alt="DANA" height="32" class="me-2">
                        <img src="{{ asset('images/ovo.jpg') }}" alt="OVO" height="32" class="me-2">
                        <img src="{{ asset('images/bri.jpg') }}" alt="BRI" height="32" class="me-2">
                        <img src="{{ asset('images/bca.png') }}" alt="BCA" height="32">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

@section('styles')
<style>
.footer-modern {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    color: #e2e8f0;
    margin-top: 5rem;
}

.footer-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image:
        radial-gradient(circle at 20% 80%, rgba(120,119,198,0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255,119,198,0.3) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(120,219,255,0.2) 0%, transparent 50%);
    background-size: 200% 200%;
    animation: gradientShift 15s ease infinite;
    z-index: 1;
}

@keyframes gradientShift {
    0%, 100% { transform: translateX(0) translateY(0) rotate(0deg); }
    33% { transform: translateX(10%) translateY(-10%) rotate(120deg); }
    66% { transform: translateX(-10%) translateY(10%) rotate(240deg); }
}

.brand-logo {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-size: 2rem;
    font-weight: 800;
    letter-spacing: -0.05em;
}

.social-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    color: #fff;
    text-decoration: none;
    font-size: 1.2rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    margin-right: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.social-btn.facebook { background: linear-gradient(135deg, #3b5998, #2d4373); }
.social-btn.instagram { background: linear-gradient(135deg, #e4405f, #c13584); }
.social-btn.tiktok { background: linear-gradient(135deg, #000, #1a1a1a); }
.social-btn.whatsapp { background: linear-gradient(135deg, #25D366, #128C7E); }

.social-btn:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
}

.footer-title {
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    letter-spacing: 0.5px;
    position: relative;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 30px;
    height: 3px;
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
    border-radius: 2px;
}

.footer-links {
    list-style: none;
    padding: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: #94a3b8;
    text-decoration: none;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    position: relative;
}

.footer-links a::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #fbbf24, #f59e0b);
    transition: width 0.3s ease;
}

.footer-links a:hover {
    color: #fff;
    padding-left: 5px;
}

.footer-links a:hover::before {
    width: 100%;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px;
    background: rgba(255,255,255,0.05);
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
}

.contact-item:hover {
    background: rgba(255,255,255,0.08);
    transform: translateX(10px);
}

.payment-methods img {
    filter: brightness(0) invert(1);
    transition: all 0.3s ease;
}

.payment-methods img:hover {
    filter: brightness(1) invert(0.8) sepia(0.3) saturate(2);
    transform: scale(1.1);
}

/* Responsive */
@media (max-width: 768px) {
    .brand-logo { font-size: 1.8rem; }
    .social-btn { width: 45px; height: 45px; font-size: 1.1rem; }
    .payment-methods img { height: 28px; }
}

@media (max-width: 576px) {
    .footer-modern { margin-top: 3rem; }
    .contact-row { text-align: center; }
    .contact-item { justify-content: center; flex-direction: column; text-align: center; }
}
</style>
@endsection
