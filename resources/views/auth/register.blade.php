@extends('layouts.app')

@section('title', 'Daftar - Toko Dwaa Lux')

@section('content')
<div class="min-vh-100 d-flex align-items-center"
     style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">

    <div class="container">
        <div class="row justify-content-center align-items-center">
            <!-- Left Side - Visual / Welcome Message -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="pe-5">
                    <h1 class="display-4 fw-bold text-dark mb-4">Selamat Datang di Toko Dwaa Lux</h1>
                    <p class="lead text-secondary mb-5">
                        Daftar sekarang dan temukan koleksi lampu elegan untuk setiap sudut rumah impianmu.
                    </p>
                    <div class="d-flex gap-3">
                        <div class="flex-grow-1">
                            <img src="{{ asset('images/gambar Toko lampu .png') }}" class="rounded-4 shadow-lg w-100" alt="Lampu mewah">
                        </div>
                        <div class="flex-grow-1">
                            <img src="{{ asset('images/lampu1.jpg') }}" class="rounded-4 shadow-lg w-100" alt="Interior terang">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Register Form -->
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-xl rounded-4 overflow-hidden bg-white"
                     style="backdrop-filter: blur(10px);">
                    <div class="card-body p-5 p-lg-6">
                        <!-- Logo & Title -->
                        <div class="text-center mb-5">
                            <img src="{{ asset('images/logo.png') }}" alt="Toko Dwaa Lux" class="mb-4" style="max-height: 70px;">
                            <h2 class="fw-bold mb-2">Buat Akun Baru</h2>
                            <p class="text-muted">Mulai belanja lampu premium hari ini</p>
                        </div>

                        <!-- Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4">
                                <input type="text" name="name" class="form-control form-control-lg rounded-pill py-3 px-4"
                                       placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <input type="email" name="email" class="form-control form-control-lg rounded-pill py-3 px-4"
                                       placeholder="Email" value="{{ old('email') }}" required>
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <input type="password" name="password" id="password" class="form-control form-control-lg rounded-pill py-3 px-4"
                                       placeholder="Kata Sandi" required>
                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-3"
                                        onclick="togglePassword('password')">
                                    <i class="bi bi-eye-slash" id="toggleIconPassword"></i>
                                </button>
                                @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-5">
                                <input type="password" name="password_confirmation" id="password-confirm" class="form-control form-control-lg rounded-pill py-3 px-4"
                                       placeholder="Konfirmasi Kata Sandi" required>
                                <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-3"
                                        onclick="togglePassword('password-confirm')">
                                    <i class="bi bi-eye-slash" id="toggleIconConfirm"></i>
                                </button>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill fw-bold shadow-lg">
                                Daftar Sekarang
                            </button>
                        </form>

                        <!-- Social & Login -->
                        <div class="text-center my-4">
                            <p class="text-muted">atau daftar dengan</p>
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-danger rounded-pill w-100 mb-3">
                                <i class="bi bi-google me-2"></i> Daftar dengan Google
                            </a>
                        </div>

                        <p class="text-center text-muted mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-primary fw-medium text-decoration-none">
                                Masuk sekarang
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Password Script -->
<script>
    function togglePassword(fieldId) {
        const input = document.getElementById(fieldId);
        const icon = document.getElementById('toggleIcon' + fieldId.charAt(0).toUpperCase() + fieldId.slice(1));
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
@endsection

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    }
    .shadow-xl {
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(59,130,246,0.3);
    }
</style>
@endsection
