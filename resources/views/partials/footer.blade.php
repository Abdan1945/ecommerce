{{-- ================================================
FILE: resources/views/partials/footer.blade.php
KEREN & MODERN SIAP COPY-PASTE
================================================ --}}
<footer class="footer-modern position-relative overflow-hidden">
    <div class="footer-bg"></div>

    <div class="container position-relative z-2">
        <div class="row g-4 py-5">
            <div class="col-lg-4 col-md-6" data-aos="fade-right">
                <div class="brand-section mb-4">
                    <h3 class="brand-logo mb-3">
                        <i class="bi bi-bag-heart-fill text-warning me-3"></i>
                        DwaaLux
                    </h3>
                    <p class="text-light opacity-90 lh-lg">
                        Toko online #1 di Indonesia. Kualitas terjamin, 
                        harga murah, pengiriman cepat ke seluruh wilayah.
                    </p>
                    <div class="social-links mt-4">
                        <a href="#" class="social-btn whatsapp" title="WhatsApp" data-aos="zoom-in" data-aos-delay="200">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <h6 class="footer-title mb-4">Menu Utama</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('catalog.index') }}">Katalog Produk</a></li>
                    <li><a href="#">Promo & Diskon</a></li>
                    <li><a href="#">Tentang Kami</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <h6 class="footer-title mb-4">Belanja</h6>
                <ul class="footer-links">
                    <li><a href="#">Keranjang</a></li>
                    <li><a href="#">Checkout</a></li>
                    <li><a href="#">Lacak Pesanan</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <h6 class="footer-title mb-4">Bantuan</h6>
                <ul class="footer-links">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                </ul>
            </div>
        </div>

        <div class="contact-row row g-3 mb-5 pb-4">
            <div class="col-md-6" data-aos="fade-up">
                <div class="contact-item">
                    <i class="bi bi-geo-alt-fill text-warning fs-5"></i>
                    <span class="small opacity-75">Jl. Raya Jakarta No. 123, Bandung</span>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-item">
                    <i class="bi bi-telephone-fill text-warning fs-5"></i>
                    <span class="small opacity-75">0852-8446-317</span>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-item">
                    <i class="bi bi-envelope-fill text-warning fs-5"></i>
                    <span class="small opacity-75">hello@dwaalux.com</span>
                </div>
            </div>
        </div>

        <div class="bottom-bar">
            <hr class="border-secondary border-2 opacity-25 mb-4">
            <div class="row align-items-center g-4">
                <div class="col-lg-6 text-center text-lg-start">
                    <p class="text-light opacity-75 mb-0 small">
                        © {{ date('Y') }} <strong class="text-warning">DwaaLux</strong>. Semua hak dilindungi.
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

<style>
.footer-modern {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #cbd5e1;
    padding: 3rem 0 2rem;
}

.footer-bg {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: radial-gradient(circle at 10% 90%, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
    z-index: 1;
}

.brand-logo {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 800;
}

.footer-links { list-style: none; padding: 0; }
.footer-links a { color: #94a3b8; text-decoration: none; transition: 0.3s; font-size: 0.9rem; }
.footer-links a:hover { color: #fbbf24; padding-left: 5px; }

.contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: rgba(255,255,255,0.03);
    border-radius: 10px;
}

/* STYLE LOGO PEMBAYARAN */
.payment-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    justify-content: flex-end;
}

.payment-box {
    width: 45px;
    height: 28px;
    background: white;
    border-radius: 4px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: 0.3s;
}

.payment-box img {
    height: 18px;
    width: auto;
    max-width: 90%;
    object-fit: contain;
}

/* Style Jika Gambar Error/Hilang */
.payment-fallback {
    width: 100%;
    height: 100%;
    display: none; /* Akan muncul via JavaScript onerror */
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 10px;
    font-weight: bold;
    text-transform: uppercase;
}

.payment-box:hover { transform: translateY(-3px); }

.social-btn {
    width: 35px; height: 35px;
    display: inline-flex;
    align-items: center; justify-content: center;
    background: #25D366;
    color: white;
    border-radius: 50%;
    text-decoration: none;
}

@media (max-width: 991px) {
    .payment-wrapper { justify-content: center; }
    .text-lg-start, .text-lg-end { text-align: center !important; }
}
</style>