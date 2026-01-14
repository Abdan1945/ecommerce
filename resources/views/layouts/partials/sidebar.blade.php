<aside class="left-sidebar">
    <div class="sidebar-container">
        
        <div class="brand-logo d-flex align-items-center justify-content-between px-4">
            <a href="{{ url('/') }}" class="logo-img d-flex align-items-center text-decoration-none">
                <div class="logo-wrapper">
                    <img src="{{ asset('images/admin.webp') }}" 
                         alt="Logo" 
                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=Admin&background=5d87ff&color=fff';">
                </div>
                <div class="brand-text ms-3">
                    <span class="fw-bolder text-dark fs-5 d-block">Admin Panel</span>
                    <span class="text-muted small" style="font-size: 10px; letter-spacing: 1px;">MANAGEMENT SYSTEM</span>
                </div>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>

        <nav class="sidebar-nav px-3">
            <ul id="sidebarnav">
                
                <li class="nav-label">Main Menu</li>
                
                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="/admin/dashboard">
                        <i class="ti ti-layout-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-label">Inventory & Sales</li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('admin/categories*') ? 'active' : '' }}" href="/admin/categories">
                        <i class="ti ti-category"></i>
                        <span>Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('admin/products*') ? 'active' : '' }}" href="/admin/products">
                        <i class="ti ti-package"></i>
                        <span>Produk</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link {{ Request::is('admin/orders*') ? 'active' : '' }}" href="/admin/orders">
                        <i class="ti ti-receipt"></i>
                        <span>Pesanan</span>
                    </a>
                </li>

                <li class="py-4"></li>
            </ul>
        </nav>
    </div>
</aside>
<style>
    /* Root Variables untuk kemudahan kustomisasi warna */
    :root {
        --primary-color: #5d87ff;
        --primary-light: rgba(93, 135, 255, 0.1);
        --sidebar-bg: #ffffff;
        --text-main: #2a3547;
        --text-muted: #7c8fac;
        --transition-speed: 0.3s;
        --border-color: #dfe5ef;
    }

    /* Main Sidebar Container */
    .left-sidebar {
        background: var(--sidebar-bg);
        border-right: 1px dashed var(--border-color);
        height: 100vh;
        width: 270px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
        transition: all var(--transition-speed) ease;
    }

    /* Logo Section */
    .brand-logo {
        height: 90px;
        border-bottom: 1px solid rgba(0,0,0,0.03);
        margin-bottom: 15px;
    }

    .logo-wrapper {
        position: relative;
    }

    .logo-wrapper img {
        width: 45px;
        height: 45px;
        border-radius: 14px;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 4px 15px rgba(93, 135, 255, 0.2);
        transition: transform 0.5s ease;
    }

    .logo-img:hover .logo-wrapper img {
        transform: rotate(5deg) scale(1.05);
    }

    /* Label Menu (Text Abu-abu Kecil) */
    .nav-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--text-muted);
        padding: 25px 15px 10px;
        list-style: none;
    }

    /* Link Menu */
    #sidebarnav {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 12px 18px;
        margin-bottom: 5px;
        color: var(--text-main);
        text-decoration: none;
        border-radius: 12px;
        transition: all var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    /* Ikon Menu */
    .sidebar-link i {
        font-size: 22px;
        margin-right: 14px;
        color: var(--text-muted);
        transition: all var(--transition-speed) ease;
    }

    .sidebar-link span {
        font-weight: 500;
        font-size: 15px;
    }

    /* Hover State */
    .sidebar-link:hover {
        background-color: var(--primary-light);
        color: var(--primary-color);
        transform: translateX(5px);
    }

    .sidebar-link:hover i {
        color: var(--primary-color);
    }

    /* Active State (Halaman yang sedang dibuka) */
    .sidebar-link.active {
        background: var(--primary-color) !important;
        color: #ffffff !important;
        box-shadow: 0 10px 20px rgba(93, 135, 255, 0.3);
    }

    .sidebar-link.active i, 
    .sidebar-link.active span {
        color: #ffffff !important;
    }

    /* Indikator Titik Putih saat Active */
    .sidebar-link.active::after {
        content: "";
        position: absolute;
        right: 15px;
        width: 6px;
        height: 6px;
        background: rgba(255,255,255,0.7);
        border-radius: 50%;
    }

    /* Scrollbar Tipis */
    .sidebar-nav {
        height: calc(100vh - 100px);
        overflow-y: auto;
    }

    .sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: #e2e2e2;
    }

    
    @media (max-width: 1199px) {
        .left-sidebar {
            left: -270px; 
        }
</style>