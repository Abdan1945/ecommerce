{{-- ================================================
FILE: resources/views/layouts/app.blade.php
FUNGSI: Master layout untuk halaman customer/publik
================================================ --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan berbagai produk berkualitas. Belanja mudah, aman, dan nyaman.')">

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    @include('partials.navbar')

    <div class="min-h-screen flex flex-col">
        <div class="container mx-auto px-4 mt-4">
            @include('partials.flash-messages')
        </div>

        <main class="flex-1 container mx-auto px-4 py-8">
            @yield('content')
        </main>

        <footer class="mt-auto">
            @include('partials.footer')
        </footer>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    @stack('scripts')

    <script>
  /**
   * INISIALISASI AOS
   * Wajib dipanggil agar atribut data-aos="fade-up" dll bekerja.
   */
  document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
      duration: 800,
      once: true,
      easing: 'ease-in-out',
    });
  });

  /**
   * Fungsi AJAX untuk Toggle Wishlist
   * Tetap dipertahankan tanpa perubahan logika.
   */
  async function toggleWishlist(productId) {
    try {
      const token = document.querySelector('meta[name="csrf-token"]').content;

      const response = await fetch(`/wishlist/toggle/${productId}`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": token,
        },
      });

      if (response.status === 401) {
        window.location.href = "/login";
        return;
      }

      const data = await response.json();

      if (data.status === "success") {
        updateWishlistUI(productId, data.added);
        updateWishlistCounter(data.count);
        // Jika kamu tidak punya fungsi showToast, alert bisa digunakan sementara
        if (typeof showToast === "function") {
            showToast(data.message);
        } else {
            console.log(data.message);
        }
      }
    } catch (error) {
      console.error("Error:", error);
    }
  }

  function updateWishlistUI(productId, isAdded) {
    const buttons = document.querySelectorAll(`.wishlist-btn-${productId}`);

    buttons.forEach((btn) => {
      const icon = btn.querySelector("i");
      if (isAdded) {
        icon.classList.remove("bi-heart", "text-secondary");
        icon.classList.add("bi-heart-fill", "text-danger");
      } else {
        icon.classList.remove("bi-heart-fill", "text-danger");
        icon.classList.add("bi-heart", "text-secondary");
      }
    });
  }

  function updateWishlistCounter(count) {
    const badge = document.getElementById("wishlist-count");
    if (badge) {
      badge.innerText = count;
      badge.style.display = count > 0 ? "inline-block" : "none";
    }
  }
</script>
</body>
</html>
