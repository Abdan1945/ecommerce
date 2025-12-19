{{-- ================================================
FILE: resources/views/layouts/app.blade.php
FUNGSI: Master layout untuk halaman customer/publik
================================================ --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token untuk AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan berbagai produk berkualitas. Belanja mudah, aman, dan nyaman.')">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite CSS & JS (Tailwind + Alpine.js jika ada) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Stack untuk CSS tambahan per halaman -->
    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <!-- NAVBAR (bisa fixed atau tidak, tergantung partials.navbar) -->
    @include('partials.navbar')

    <!-- Wrapper utama untuk konten -->
    <div class="min-h-screen flex flex-col">
        <!-- Flash Messages -->
        <div class="container mx-auto px-4 mt-4">
            @include('partials.flash-messages')
        </div>

        <!-- MAIN CONTENT -->
        <main class="flex-1 container mx-auto px-4 py-8">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="mt-auto">
            @include('partials.footer')
        </footer>
    </div>

    <!-- Stack untuk JS tambahan per halaman -->
    @stack('scripts')
</body>
</html>
