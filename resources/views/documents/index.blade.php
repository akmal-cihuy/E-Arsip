@extends('layouts.app')
@section('page_title', 'Daftar File')

@section('content')
<div class="card card-custom p-4 mb-4">
    <!-- Filter Bar -->
    <form action="{{ route('documents.index') }}" method="GET" class="row g-2 align-items-end mb-3">
        <div class="col-md-3">
            <label class="small fw-semibold">Pencarian</label>
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Nama File..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label class="small fw-semibold">Kategori</label>
            <select name="category_id" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="small fw-semibold">Folder</label>
            <select name="folder_id" class="form-select form-select-sm">
                <option value="">Semua Folder</option>
                @foreach($folders as $folder)
                    <option value="{{ $folder->id }}" {{ request('folder_id') == $folder->id ? 'selected' : '' }}>{{ $folder->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-orange btn-sm w-100"><i class="bi bi-filter"></i> Filter</button>
            <a href="{{ route('documents.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>

    <!-- Table Dokumen -->
    @if($documents->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-3">
                <thead class="table-light small">
                    <tr>
                        <th>No</th>
                        <th>Nama File</th>
                        <th>Kategori</th>
                        <th>Folder</th>
                        <th>Ukuran</th>
                        <th>Tgl File</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="small">
                    @foreach($documents as $index => $doc)
                        <tr>
                            <td>{{ $documents->firstItem() + $index }}</td>
                            <td>
                                <a href="{{ route('documents.show', $doc->id) }}" class="fw-bold text-dark text-decoration-none">{{ $doc->name }}</a>
                                <div class="text-muted" style="font-size: 0.75rem;">No: {{ $doc->document_number }}</div>
                            </td>
                            <td><span class="badge badge-orange">{{ $doc->category->name }}</span></td>
                            <td><i class="bi bi-folder-fill text-warning me-1"></i> {{ $doc->folder->name ?? 'Root' }}</td>
                            <td>{{ $doc->formatted_size }}</td>
                            <td>{{ $doc->document_date->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-light" title="Detail"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('documents.download', $doc->id) }}" class="btn btn-light" title="Download"><i class="bi bi-download"></i></a>
                                    <button type="button" class="btn btn-light text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $doc->id }}" title="Hapus"><i class="bi bi-trash"></i></button>
                                </div>

                                <!-- Modal Konfirmasi Hapus -->
                                <div class="modal fade" id="deleteModal{{ $doc->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-body text-center p-4">
                                                <i class="bi bi-exclamation-triangle text-danger display-4 mb-3"></i>
                                                <h6>Hapus File?</h6>
                                                <p class="text-muted small">File <strong>{{ $doc->name }}</strong> akan dihapus permanen.</p>
                                                <div class="d-flex justify-content-center gap-2 mt-3">
                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('documents.destroy', $doc->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Ya, Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end">
            {{ $documents->links('pagination::bootstrap-5') }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="d-inline-flex align-items-center justify-content-center p-4 rounded-circle mb-3" style="background-color: var(--primary-orange-light); color: var(--primary-orange);">
                <i class="bi bi-folder-x fs-1"></i>
            </div>
            <h5 class="fw-bold">Belum ada file</h5>
            <p class="text-muted small">Tidak ada data arsip yang sesuai dengan kriteria filter Anda.</p>
            <a href="{{ route('documents.create') }}" class="btn btn-orange btn-sm mt-2">
                <i class="bi bi-cloud-arrow-up me-1"></i> Upload File
            </a>
        </div>
    @endif
</div>
@endsection