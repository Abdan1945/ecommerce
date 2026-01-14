@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="row fade-in">
    <div class="col-lg-12">
        {{-- Alert Notifikasi --}}
        @if(session('success'))
            <div class="alert alert-custom alert-success border-0 shadow-sm alert-dismissible fade show mb-4 mt-2">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-custom alert-danger border-0 shadow-sm mb-4 mt-2">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-sm mb-4 overflow-hidden">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                <h5 class="mb-0 text-dark fw-bold">
                    <i class="bi bi-grid-fill text-primary me-2"></i>Daftar Kategori
                </h5>
                <button class="btn btn-primary btn-hover-scale shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-lg me-1"></i> Kategori Baru
                </button>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted text-uppercase fs-xs">Detail Kategori</th>
                                <th class="text-center text-muted text-uppercase fs-xs">Total Produk</th>
                                <th class="text-center text-muted text-uppercase fs-xs">Status</th>
                                <th class="text-end pe-4 text-muted text-uppercase fs-xs">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr class="category-row">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="image-wrapper me-3">
                                                @if($category->image)
                                                    <img src="{{ asset('storage/' . $category->image) }}" class="rounded-3 shadow-sm border" width="50" height="50" style="object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded-3 border d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="bi bi-tag text-muted fs-4"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $category->name }}</div>
                                                <small class="text-muted d-block">slug: <span class="text-primary">{{ $category->slug }}</span></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border fw-medium rounded-pill px-3">{{ $category->products_count ?? 0 }} Produk</span>
                                    </td>
                                    <td class="text-center">
                                        @if($category->is_active)
                                            <span class="status-badge active"><i class="bi bi-circle-fill me-1"></i> Aktif</span>
                                        @else
                                            <span class="status-badge inactive"><i class="bi bi-circle-fill me-1"></i> Non-Aktif</span>
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
                                <div class="modal fade zoom-in" id="editModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg">
                                            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header border-bottom-0 pt-4 px-4">
                                                    <h5 class="modal-title fw-bold">Edit Kategori</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body px-4 pb-4">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Nama Kategori</label>
                                                        <input type="text" name="name" class="form-control form-control-lg fs-6 shadow-none" value="{{ $category->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Ganti Gambar</label>
                                                        <div class="input-group">
                                                            <input type="file" name="image" class="form-control shadow-none" accept="image/*">
                                                        </div>
                                                        <small class="text-muted mt-1 d-block"><i class="bi bi-info-circle me-1"></i>Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                                    </div>
                                                    <div class="bg-light p-3 rounded-3 mt-4">
                                                        <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0">
                                                            <label class="form-check-label fw-bold mb-0" for="switch{{$category->id}}">Status Kategori</label>
                                                            <input type="hidden" name="is_active" value="0">
                                                            <input class="form-check-input ms-0 mt-0" style="width: 3em; height: 1.5em; cursor: pointer;" type="checkbox" name="is_active" value="1" id="switch{{$category->id}}" {{ $category->is_active ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top-0 px-4 pb-4">
                                                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="py-4">
                                            <i class="bi bi-folder-x display-1 d-block mb-3 opacity-25"></i>
                                            <h6 class="fw-bold">Belum ada kategori ditemukan.</h6>
                                        </div>
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
<div class="modal fade zoom-in" id="createModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4 pb-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" name="name" class="form-control form-control-lg fs-6 shadow-none" required placeholder="Contoh: Sepatu Olahraga">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Gambar Cover</label>
                        <input type="file" name="image" class="form-control shadow-none" accept="image/*">
                    </div>
                    <div class="bg-light p-3 rounded-3 mt-4">
                        <div class="form-check form-switch d-flex justify-content-between align-items-center ps-0">
                            <label class="form-check-label fw-bold mb-0" for="switchCreate">Aktifkan Sekarang</label>
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input ms-0 mt-0" style="width: 3em; height: 1.5em; cursor: pointer;" type="checkbox" name="is_active" value="1" id="switchCreate" checked>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Animasi Dasar */
    .fade-in { animation: fadeIn 0.5s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .zoom-in .modal-content { animation: zoomIn 0.3s ease-out; }
    @keyframes zoomIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }

    /* Custom Badges */
    .status-badge {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
    }
    .status-badge.active { background-color: #e8fadf; color: #28a745; }
    .status-badge.inactive { background-color: #f8f9fa; color: #6c757d; }
    .status-badge i { font-size: 6px; }

    /* Buttons */
    .btn-hover-scale { transition: all 0.2s; }
    .btn-hover-scale:hover { transform: translateY(-2px); }
    
    .btn-icon {
        width: 40px; /* Ukuran diperbesar sedikit */
        height: 40px; /* Ukuran diperbesar sedikit */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: none;
        transition: all 0.2s;
    }
    .btn-warning-soft { background-color: #fff8e6; color: #f39c12; }
    .btn-warning-soft:hover { background-color: #f39c12; color: white; }
    
    .btn-danger-soft { background-color: #ffeef0; color: #dc3545; }
    .btn-danger-soft:hover { background-color: #dc3545; color: white; }

    /* UI Helper */
    .fs-xs { font-size: 11px; letter-spacing: 0.5px; }
    .category-row { transition: background 0.2s; }
    .category-row:hover { background-color: #fbfcfe !important; }
    .image-wrapper img { transition: transform 0.3s; }
    .category-row:hover .image-wrapper img { transform: scale(1.1); }
    
    .form-control:focus {
        border-color: #5d87ff;
        background-color: #fff;
    }
</style>
@endsection