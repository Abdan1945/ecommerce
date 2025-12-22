<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('admin.dashboard') }}" class="text-nowrap logo-img">
        <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>

    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <!-- Home -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Home</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
            <span>
              <i class="ti ti-layout-dashboard"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        <!-- Manajemen Toko -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Manajemen Toko</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.categories.index') }}" aria-expanded="false">
            <span>
              <i class="ti ti-category"></i>
            </span>
            <span class="hide-menu">Categories</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.products.index') }}" aria-expanded="false">
            <span>
              <i class="ti ti-package"></i>
            </span>
            <span class="hide-menu">Products</span>
          </a>
        </li>
        {{-- <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.orders.index') }}" aria-expanded="false">
            <span>
              <i class="ti ti-package"></i>
            </span>
            <span class="hide-menu">Order</span>
          </a>
        </li> --}}
        {{-- <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.users.index') }}" aria-expanded="false">
            <span>
              <i class="ti ti-package"></i>
            </span>
            <span class="hide-menu">User</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.reports.sales') }}" aria-expanded="false">
            <span>
              <i class="ti ti-package"></i>
            </span>
            <span class="hide-menu">Laporan Pesanan</span>
          </a>
        </li> --}}
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
