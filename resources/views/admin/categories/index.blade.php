@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="row">
    <div class="col-lg-12">
        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold"><i class="bi bi-grid-fill me-2"></i>Daftar Kategori</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-lg me-1"></i> Kategori Baru
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Detail Kategori</th>
                                <th class="text-center">Total Produk</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @if($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}" class="rounded shadow-sm me-3" width="45" height="45" style="object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                                    <i class="bi bi-tag text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $category->name }}</div>
                                                <small class="text-muted">slug: {{ $category->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border">{{ $category->products_count ?? 0 }} Produk</span>
                                    </td>
                                    <td class="text-center">
                                        @if($category->is_active)
                                            <span class="badge bg-success-subtle text-success px-3">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary px-3">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brush" viewBox="0 0 16 16">
                                        <path d="M15.825.12a.5.5 0 0 1 .132.584c-1.53 3.43-4.743 8.17-7.095 10.64a6.1 6.1 0 0 1-2.373 1.534c-.018.227-.06.538-.16.868-.201.659-.667 1.479-1.708 1.74a8.1 8.1 0 0 1-3.078.132 4 4 0 0 1-.562-.135 1.4 1.4 0 0 1-.466-.247.7.7 0 0 1-.204-.288.62.62 0 0 1 .004-.443c.095-.245.316-.38.461-.452.394-.197.625-.453.867-.826.095-.144.184-.297.287-.472l.117-.198c.151-.255.326-.54.546-.848.528-.739 1.201-.925 1.746-.896q.19.012.348.048c.062-.172.142-.38.238-.608.261-.619.658-1.419 1.187-2.069 2.176-2.67 6.18-6.206 9.117-8.104a.5.5 0 0 1 .596.04M4.705 11.912a1.2 1.2 0 0 0-.419-.1c-.246-.013-.573.05-.879.479-.197.275-.355.532-.5.777l-.105.177c-.106.181-.213.362-.32.528a3.4 3.4 0 0 1-.76.861c.69.112 1.736.111 2.657-.12.559-.139.843-.569.993-1.06a3 3 0 0 0 .126-.75zm1.44.026c.12-.04.277-.1.458-.183a5.1 5.1 0 0 0 1.535-1.1c1.9-1.996 4.412-5.57 6.052-8.631-2.59 1.927-5.566 4.66-7.302 6.792-.442.543-.795 1.243-1.042 1.826-.121.288-.214.54-.275.72v.001l.575.575zm-4.973 3.04.007-.005zm3.582-3.043.002.001h-.002z"/>
                                                </svg>
                                            </button>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                                  class="d-inline ms-1" onsubmit="return confirm('Hapus kategori ini? Produk di dalamnya mungkin akan kehilangan kategori.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                              <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                {{-- MODAL EDIT --}}
                                <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Kategori</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nama Kategori</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Ganti Gambar</label>
                                                        <input type="file" name="image" class="form-control" accept="image/*">
                                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                                    </div>
                                                    <div class="form-check form-switch mt-3">
                                                        <input type="hidden" name="is_active" value="0">
                                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="switch{{$category->id}}" {{ $category->is_active ? 'checked' : '' }}>
                                                        <label class="form-check-label fw-bold" for="switch{{$category->id}}">Status Aktif</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-warning px-4">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder-x display-4 d-block mb-3"></i>
                                        Belum ada kategori ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH (Create) --}}
<div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Sepatu Olahraga">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Cover</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="switchCreate" checked>
                        <label class="form-check-label fw-bold" for="switchCreate">Aktifkan Sekarang</label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
