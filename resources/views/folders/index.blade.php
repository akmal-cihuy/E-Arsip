@extends('layouts.app')
@section('page_title', 'Manajemen Folder')

@section('content')
<div class="card card-custom p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Folder Arsip</h5>
            <p class="text-muted small mb-0">Kelola hierarki dan struktur direktori pengarsipan file.</p>
        </div>
        <button class="btn btn-orange btn-sm" data-bs-toggle="modal" data-bs-target="#createFolderModal">
            <i class="bi bi-folder-plus me-1"></i> Buat Folder Baru
        </button>
    </div>

    <!-- Grid Folder -->
    <div class="row g-3">
        @forelse($folders as $folder)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card card-custom p-3 h-100 border position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <i class="bi bi-folder-fill fs-1 text-warning"></i>
                        <div class="dropdown">
                            <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                <li>
                                    <button class="dropdown-item small" data-bs-toggle="modal" data-bs-target="#editFolderModal{{ $folder->id }}">
                                        <i class="bi bi-pencil me-2 text-primary"></i> Edit
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item small" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $folder->id }}" title="Hapus"><i class="bi bi-trash text-danger"></i>  hapus</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="deleteModal{{ $folder->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center p-4">
                                            <i class="bi bi-exclamation-triangle text-danger display-4 mb-3"></i>
                                                <h6>Hapus folder?</h6>
                                                <p class="text-muted small">Folder <strong>{{ $folder->name }}</strong> akan dihapus permanen.</p>
                                                    <div class="d-flex justify-content-center gap-2 mt-3">
                                                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                                                            <form action="{{ route('folders.destroy', $folder->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
                                                            </form>
                                                    </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                    <a href="{{ route('folders.show', $folder->id) }}" class="fw-bold text-dark text-decoration-none text-truncate d-block mb-1">
                        {{ $folder->name }}
                    </a>
                    <p class="text-muted small mb-2 text-truncate">{{ $folder->description ?? 'Tidak ada deskripsi' }}</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top small text-muted">
                        <span><i class="bi bi-file-earmark me-1"></i> {{ $folder->files_count }} File</span>
                        <span><i class="bi bi-folder2-open me-1"></i> {{ $folder->subfolders->count() }} Sub</span>
                    </div>
                </div>

                <!-- Modal Edit Folder -->
                <div class="modal fade" id="editFolderModal{{ $folder->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('folders.update', $folder->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h6 class="modal-title fw-bold">Edit Folder</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Nama Folder</label>
                                        <input type="text" name="name" class="form-control" value="{{ $folder->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Folder Induk (Opsional)</label>
                                        <select name="parent_id" class="form-select">
                                            <option value="">(Tidak Ada / Root)</option>
                                            @foreach($allFolders as $p)
                                                @if($p->id !== $folder->id)
                                                    <option value="{{ $p->id }}" {{ $folder->parent_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">Deskripsi</label>
                                        <textarea name="description" class="form-control" rows="2">{{ $folder->description }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-orange btn-sm">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="bi bi-folder-x fs-1 text-muted"></i>
                <p class="text-muted small mt-2">Belum ada folder yang dibuat.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $folders->links('pagination::bootstrap-5') }}
    </div>
</div>

<!-- Modal Create Folder -->
<div class="modal fade" id="createFolderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('folders.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Buat Folder Baru</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Folder <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: SDM & Penggajian" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Folder Induk (Opsional)</label>
                        <select name="parent_id" class="form-select">
                            <option value="">(Tidak Ada / Root)</option>
                            @foreach($allFolders as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Keterangan singkat berkas dalam folder"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-orange btn-sm">Buat Folder</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection