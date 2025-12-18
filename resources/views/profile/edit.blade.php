{{-- resources/views/profile/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <h2 class="text-center mb-5 fw-bold text-primary">Profil Saya </h2>

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-5" role="alert">
                    <strong>Berhasil!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- 1. Foto Profil -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-primary text-white fw-bold py-3">
                    <i class="fas fa-user-circle me-2"></i> Foto Profil
                </div>
                <div class="card-body p-5">
                    @include('profile.partials.update-avatar-form')
                </div>
            </div>

            <!-- 2. Informasi Profil -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-primary text-white fw-bold py-3">
                    <i class="fas fa-id-card me-2"></i> Informasi Profil
                </div>
                <div class="card-body p-5">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- 3. Update Password -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-primary text-white fw-bold py-3">
                    <i class="fas fa-lock me-2"></i> Update Password
                </div>
                <div class="card-body p-5">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- 4. Akun Terhubung -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-primary text-white fw-bold py-3">
                    <i class="fas fa-link me-2"></i> Akun Terhubung
                </div>
                <div class="card-body p-5">
                    @include('profile.partials.connected-accounts')
                </div>
            </div>

            <!-- 5. Hapus Akun -->
            <div class="card shadow-sm border-0 border-danger border-3">
                <div class="card-header bg-danger text-white fw-bold py-3">
                    <i class="fas fa-trash-alt me-2"></i> Hapus Akun Permanen
                </div>
                <div class="card-body p-5 bg-light">
                    <p class="text-danger fw-medium">
                        <strong>Peringatan:</strong> Setelah akun dihapus, semua data akan hilang selamanya dan tidak bisa dikembalikan.
                    </p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
