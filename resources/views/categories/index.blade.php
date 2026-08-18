@extends('layouts.app')
@section('page_title', 'Kategori Dokumen')

@section('content')
<div class="card card-custom p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Daftar Kategori Arsip</h5>
            <p class="text-muted small mb-0">Klasifikasikan tipe file.</p>
        </div>
        <button class="btn btn-orange btn-sm" data-bs-toggle="modal" data-bs-target="#createCatModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3 small">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Total File</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $idx => $cat)
                    <tr>
                        <td>{{ $categories->firstItem() + $idx }}</td>
                        <td class="fw-bold">{{ $cat->name }}</td>
                        <td>{{ $cat->description ?? '-' }}</td>
                        <td><span class="badge badge-orange">{{ $cat->documents_count }} File</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#editCatModal{{ $cat->id }}"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $cat->id }}" title="Hapus"><i class="bi bi-trash"></i></button>

                        <div class="modal fade" id="deleteModal{{ $cat->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-body text-center p-4">
                                            <i class="bi bi-exclamation-triangle text-danger display-4 mb-3"></i>
                                                <h6>Hapus kategori?</h6>
                                                <p class="text-muted small">Kategori <strong>{{ $cat->name }}</strong> akan dihapus permanen.</p>
                                                    <div class="d-flex justify-content-center gap-2 mt-3">
                                                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                                                            <form action="{{ route('categories.destroy', $cat->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
                                                            </form>
                                                    </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                            <!-- Modal Edit Kategori -->
                            <div class="modal fade" id="editCatModal{{ $cat->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content text-start">
                                        <form action="{{ route('categories.update', $cat->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h6 class="modal-title fw-bold">Edit Kategori</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Nama Kategori</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold">Deskripsi</label>
                                                    <textarea name="description" class="form-control" rows="2">{{ $cat->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-orange btn-sm">Perbarui</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada kategori arsip.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $categories->links('pagination::bootstrap-5') }}
</div>

<!-- Modal Create Kategori -->
<div class="modal fade" id="createCatModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title fw-bold">Tambah Kategori Arsip</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Pajak & Retribusi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Catatan kegunaan kategori"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-orange btn-sm">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection