{{-- ================================================
FILE: resources/views/layouts/admin.blade.php
FUNGSI: Master layout untuk halaman Admin Dashboard (Modernize Free Template)
================================================ --}}

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token untuk AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />

    <!-- Google Fonts: Inter (konsisten dengan sisi customer) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Modernize Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />

    <!-- Stack untuk CSS tambahan per halaman admin (jika perlu) -->
    @stack('styles')
</head>

<body>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
         data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

        <!-- Sidebar Start -->
        @include('layouts.partials.sidebar') {{-- Pastikan file ini ada dan benar --}}
        <!-- Sidebar End -->

        <!-- Main wrapper -->
        <div class="body-wrapper">
            <!-- Header Start (Navbar Admin) -->
            @include('layouts.partials.navbar') {{-- Ini navbar admin, bukan customer! --}}
            <!-- Header End -->

            <div class="container-fluid">
                <!-- Flash Messages -->
                @include('partials.flash-messages')

                <!-- Main Content -->
                @yield('content')

                <!-- Footer Template Modernize -->
                <div class="py-6 px-6 text-center">
                    <p class="mb-0 fs-4">
                        Design and Developed by
                        <a href="https://adminmart.com/" target="_blank" class="pe-1 text-primary text-decoration-underline">
                            AdminMart.com
                        </a>
                        Distributed by
                        <a href="https://themewagon.com" target="_blank">
                            ThemeWagon
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    <!-- Stack untuk JS tambahan per halaman admin -->
    @stack('scripts')
</body>

</html>
