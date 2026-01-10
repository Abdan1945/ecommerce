@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #4361ee 0%, #4cc9f0 100%);
        --glass-bg: rgba(255, 255, 255, 0.9);
    }

    body {
        background: #f8f9fa;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-card {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        border: none;
        box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        max-width: 1000px;
        width: 100%;
    }

    /* Bagian Visual (Kiri) */
    .login-visual {
        background: var(--primary-gradient);
        color: white;
        padding: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .login-visual img {
        width: 80%;
        margin-bottom: 30px;
        filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
    }

    /* Bagian Form (Kanan) */
    .login-form-area {
        padding: 50px;
    }

    .form-control {
        border-radius: 12px;
        padding: 12px 20px;
        border: 2px solid #f1f3f5;
        background-color: #f8f9fa;
        transition: all 0.3s;
    }

    .form-control:focus {
        background-color: #fff;
        border-color: #4361ee;
        box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    .btn-login {
        background: var(--primary-gradient);
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: transform 0.2s;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
    }

    .btn-google {
        border: 2px solid #f1f3f5;
        border-radius: 12px;
        padding: 10px;
        font-weight: 600;
        color: #495057;
        transition: all 0.3s;
    }

    .btn-google:hover {
        background: #f8f9fa;
        border-color: #dee2e6;
    }

    @media (max-width: 768px) {
        .login-visual { display: none; }
        .login-form-area { padding: 30px; }
    }
</style>

<div class="login-container">
    <div class="card login-card shadow-lg">
        <div class="row g-0">
            <div class="col-md-5 login-visual d-none d-md-flex">
                <img src="images/lampu3.jpg" alt="Login Illustration">
                <h3 class="fw-bold">Selamat Datang Kembali!</h3>
                <p class="opacity-75">Akses dasbor Anda dan kelola semua aktivitas dengan lebih mudah.</p>
            </div>

            <div class="col-md-7 login-form-area">
                <div class="mb-4">
                    <h2 class="fw-800 mb-1">Login Akun</h2>
                    <p class="text-muted small">Silakan masukkan detail akun Anda untuk melanjutkan.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-600 small">Alamat Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               placeholder="nama@perusahaan.com">
                        @error('email')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label fw-600 small">Password</label>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small fw-600" href="{{ route('password.request') }}">Lupa?</a>
                            @endif
                        </div>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password" placeholder="••••••••">
                        @error('password')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small" for="remember">Ingat saya</label>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-login">
                            Masuk Sekarang <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>

                    <div class="position-relative my-4">
                        <hr>
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">Atau masuk dengan</span>
                    </div>

                    <div class="d-grid mb-4">
                        <a href="{{ route('auth.google') }}" class="btn btn-google">
                            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="18" class="me-2">
                            Google Akun
                        </a>
                    </div>

                    <p class="text-center mb-0 small text-muted">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Register</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
