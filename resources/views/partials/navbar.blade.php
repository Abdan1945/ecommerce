<style>
    /* Menghilangkan garis bawah default link bootstrap */
    .nav-link {
        color: #666 !important;
        font-size: 0.95rem;
        padding-bottom: 5px !important;
        transition: all 0.2s ease;
    }

    /* Efek Menu Active (Garis di bawah kata) */
    .nav-link.active {
        color: #0d6efd !important;
    }

    /* Efek hover halus pada ikon */
    .nav-link:hover {
        color: #0d6efd !important;
    }

    /* Dropdown Profile yang rapi */
    .dropdown-menu {
        min-width: 180px;
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-2">
    <div class="container">
        {{-- Logo Brand --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <div class="bg-primary rounded-3 d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                <i class="bi bi-bag-heart-fill text-white fs-5"></i>
            </div>
            <span class="fw-bold fs-4 text-dark" style="letter-spacing: -1px;"> Toko Dwaa <span class="text-primary"> Lux</span></span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Menu Navigasi Tengah (Persis Gambar Referensi) --}}
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold border-bottom border-primary border-3' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('catalog.*') ? 'active fw-bold border-bottom border-primary border-3' : '' }}" href="{{ route('catalog.index') }}">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ auth()->check() ? route('orders.index') : route('login') }}">Pesanan Saya</a>
                </li>
            </ul>

            {{-- Menu Kanan (Ikon & Profil) --}}
            <ul class="navbar-nav align-items-center gap-3">
                <li class="nav-item">
                    <a class="nav-link p-1" href="{{ route('wishlist.index') }}">
                        <i class="bi bi-heart fs-5"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-1 position-relative" href="{{ route('cart.index') }}">
                        <i class="bi bi-bag fs-5"></i>
                        @auth
                            @php $cartCount = auth()->user()->cart?->items()->count() ?? 0; @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">{{ $cartCount }}</span>
                            @endif
                        @endauth
                    </a>
                </li>

                <li class="nav-item dropdown ms-lg-2">
                    @auth
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="userDropdown" data-bs-toggle="dropdown">
                            <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle border" width="32" height="32" style="object-fit: cover;">
                            <span class="ms-2 fw-semibold text-dark d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 rounded-4">
                            <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profil</a></li>
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item py-2 text-primary" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Admin Panel</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2 border-0 bg-transparent w-100 text-start">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Masuk</a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>
