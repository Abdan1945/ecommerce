@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
<style>
    /* Menggunakan font sistem yang bersih */
    body { background-color: #f4f7f9; }

    /* Container Wrapper */
    .profile-wrapper { margin-top: 40px; margin-bottom: 60px; }

    /* Navigasi Samping yang Rapi */
    .profile-nav .nav-link {
        color: #64748b;
        font-weight: 500;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 4px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }
    .profile-nav .nav-link i { width: 24px; font-size: 1.1rem; }
    .profile-nav .nav-link:hover { background-color: #e2e8f0; color: #1e293b; }
    .profile-nav .nav-link.active {
        background-color: #ffffff;
        color: #0d6efd;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    /* Card Styling yang Konsisten */
    .content-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 32px;
        height: 100%;
    }

    .section-header {
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 24px;
        padding-bottom: 16px;
    }
    .section-title { font-size: 1.25rem; fw-bold; color: #1e293b; }
    .section-subtitle { font-size: 0.875rem; color: #64748b; }

    /* Alert Styling */
    .alert-custom {
        border-radius: 10px;
        border: none;
        background-color: #dcfce7;
        color: #166534;
        font-weight: 500;
    }
</style>

<div class="container profile-wrapper">
    <div class="row g-4">

        {{-- Sisi Kiri: Navigasi & Ringkasan --}}
        <div class="col-lg-3">
            <div class="mb-4">
                <h4 class="fw-bold mb-1">Pengaturan</h4>
                <p class="text-muted small">Kelola akun & keamanan anda</p>
            </div>

            <nav class="nav flex-column profile-nav">
                <a class="nav-link active" id="profile-tab" data-bs-toggle="pill" href="#profile">
                    <i class="bi bi-person-circle me-2"></i> Profil Umum
                </a>
                <a class="nav-link" id="password-tab" data-bs-toggle="pill" href="#password">
                    <i class="bi bi-shield-lock me-2"></i> Kata Sandi
                </a>
                <a class="nav-link" id="accounts-tab" data-bs-toggle="pill" href="#accounts">
                    <i class="bi bi-link-45deg me-2"></i> Koneksi Akun
                </a>
                <a class="nav-link text-danger" id="danger-tab" data-bs-toggle="pill" href="#danger">
                    <i class="bi bi-exclamation-triangle me-2"></i> Privasi & Akun
                </a>
            </nav>
        </div>

        {{-- Sisi Kanan: Konten Form --}}
        <div class="col-lg-9">

            @if (session('success'))
                <div class="alert alert-custom alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="tab-content border-0">

                {{-- Bagian 1: Profil --}}
                <div class="tab-pane fade show active" id="profile">
                    <div class="content-card shadow-sm">
                        <div class="section-header">
                            <h3 class="section-title">Informasi Pribadi</h3>
                            <p class="section-subtitle">Perbarui foto profil dan detail informasi diri anda di sini.</p>
                        </div>

                        <div class="row">
                            <div class="col-xl-4 mb-4 mb-xl-0">
                                <p class="fw-bold small mb-3">Foto Profil</p>
                                @include('profile.partials.update-avatar-form')
                            </div>
                            <div class="col-xl-8">
                                <p class="fw-bold small mb-3">Detail Akun</p>
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian 2: Password --}}
                <div class="tab-pane fade" id="password">
                    <div class="content-card shadow-sm">
                        <div class="section-header">
                            <h3 class="section-title">Keamanan</h3>
                            <p class="section-subtitle">Ganti kata sandi secara berkala untuk menjaga keamanan akun.</p>
                        </div>
                        <div class="col-md-8">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- Bagian 3: Koneksi --}}
                <div class="tab-pane fade" id="accounts">
                    <div class="content-card shadow-sm">
                        <div class="section-header">
                            <h3 class="section-title">Akun Terhubung</h3>
                            <p class="section-subtitle">Kelola integrasi pihak ketiga pada akun anda.</p>
                        </div>
                        @include('profile.partials.connected-accounts')
                    </div>
                </div>

                {{-- Bagian 4: Hapus Akun --}}
                <div class="tab-pane fade" id="danger">
                    <div class="content-card shadow-sm border-danger-subtle">
                        <div class="section-header border-danger-subtle">
                            <h3 class="section-title text-danger">Hapus Akun</h3>
                            <p class="section-subtitle">Menghapus akun akan menghapus semua data secara permanen.</p>
                        </div>
                        <div class="p-3 bg-danger-subtle text-danger rounded-3 mb-4 small">
                            <strong>Peringatan:</strong> Aksi ini bersifat permanen dan tidak dapat dipulihkan kembali.
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
