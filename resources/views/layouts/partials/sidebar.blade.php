<aside class="left-sidebar shadow-sm" style="background: #fff; border-right: 1px solid rgba(0,0,0,0.05);">
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
    <a href="{{ url('/') }}" class="text-nowrap logo-img d-flex align-items-center text-decoration-none">
        <img src="{{ asset('images/admin.webp') }}"
             alt="Logo"
             width="50"
             height="50"
             style="object-fit: cover; border-radius: 50%; border: 2px solid #fbbf24;"
             onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=Toko+Kami&background=fbbf24&color=020617';">

        <span class="ms-2 fw-bold text-dark fs-5">AbdanStore</span>
    </a>

    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
    </div>
</div>

        <nav class="sidebar-nav scroll-sidebar px-3" data-simplebar="">
            <ul id="sidebarnav" class="mt-3">
                <li class="nav-small-cap mb-2">
                    <i class="ti ti-dots nav-small-cap-icon fs-4 text-primary"></i>
                    <span class="hide-menu fw-bold text-uppercase small" style="letter-spacing: 1px; color: #a1aab2;">Admin Menu</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link rounded-3 mb-1 {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="/admin/dashboard" aria-expanded="false">
                        <span class="icon-box">
                            <i class="ti ti-layout-dashboard fs-5"></i>
                        </span>
                        <span class="hide-menu fw-medium">Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link rounded-3 mb-1 {{ Request::is('admin/categories*') ? 'active' : '' }}" href="/admin/categories" aria-expanded="false">
                        <span class="icon-box">
                            <i class="ti ti-category fs-5"></i>
                        </span>
                        <span class="hide-menu fw-medium">Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link rounded-3 mb-1 {{ Request::is('admin/products*') ? 'active' : '' }}" href="/admin/products" aria-expanded="false">
                        <span class="icon-box">
                            <i class="ti ti-package fs-5"></i>
                        </span>
                        <span class="hide-menu fw-medium">Produk</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link rounded-3 mb-1 {{ Request::is('admin/orders*') ? 'active' : '' }}" href="/admin/orders" aria-expanded="false">
                        <span class="icon-box">
                            <i class="ti ti-receipt fs-5"></i>
                        </span>
                        <span class="hide-menu fw-medium">Pesanan</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<style>
    /* Transisi Halus */
    .transition-all { transition: all 0.3s ease; }

    /* Styling Link Sidebar */
    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: #5a6a85;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    /* Efek Hover */
    .sidebar-link:hover {
        background-color: rgba(93, 135, 255, 0.1);
        color: #5d87ff;
    }

    /* State Active (Jika menggunakan Laravel) */
    .sidebar-link.active {
        background-color: #5d87ff !important;
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(93, 135, 255, 0.3);
    }

    .sidebar-link.active i {
        color: #fff !important;
    }

    /* Icon Box agar lebih rapi */
    .icon-box {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        margin-right: 10px;
    }

    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }
</style>
