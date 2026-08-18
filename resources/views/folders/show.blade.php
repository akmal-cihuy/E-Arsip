@extends('layouts.app')
@section('page_title', 'Isi Folder: ' . $folder->name)

@section('content')
<div class="card card-custom p-4 mb-4">
    <!-- Breadcrumb Nav -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small mb-3">
            <li class="breadcrumb-item"><a href="{{ route('folders.index') }}" class="text-decoration-none" style="color: var(--primary-orange);">Folder Utama</a></li>
            @if($folder->parent)
                <li class="breadcrumb-item"><a href="{{ route('folders.show', $folder->parent->id) }}" class="text-decoration-none" style="color: var(--primary-orange);">{{ $folder->parent->name }}</a></li>
            @endif
            <li class="breadcrumb-item active">{{ $folder->name }}</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0"><i class="bi bi-folder2-open text-warning me-2"></i>{{ $folder->name }}</h4>
            <span class="text-muted small">{{ $folder->description ?? 'Tidak ada deskripsi' }}</span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('files.create') }}?folder_id={{ $folder->id }}" class="btn btn-orange btn-sm">
                <i class="bi bi-cloud-arrow-up me-1"></i> Upload ke Folder Ini
            </a>
        </div>
    </div>

    <!-- Subfolders if any -->
    @if($subfolders->count() > 0)
        <h6 class="fw-bold text-muted small text-uppercase mb-3">Sub-Folder</h6>
        <div class="row g-3 mb-4">
            @foreach($subfolders as $sub)
                <div class="col-md-3">
                    <div class="card card-custom p-3 border">
                        <a href="{{ route('folders.show', $sub->id) }}" class="text-dark fw-bold text-decoration-none d-flex align-items-center gap-2">
                            <i class="bi bi-folder-fill text-warning fs-4"></i>
                            <span class="text-truncate">{{ $sub->name }}</span>
                        </a>
                        <span class="text-muted small mt-2">{{ $sub->files_count }} File</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Files Inside Folder -->
    <h6 class="fw-bold text-muted small text-uppercase mb-3">Berkas File</h6>
    @if($files->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-3 small">
                <thead class="table-light">
                    <tr>
                        <th>Nama File</th>
                        <th>Kategori</th>
                        <th>Ukuran</th>
                        <th>Uploader</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($files as $file)
                        <tr>
                            <td class="fw-semibold">{{ $file->name }}</td>
                            <td><span class="badge badge-orange">{{ $file->category->name }}</span></td>
                            <td>{{ $file->formatted_size }}</td>
                            <td>{{ $file->user->name }}</td>
                            <td>
                                <a href="{{ route('files.show', $file->id) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('files.download', $file->id) }}" class="btn btn-sm btn-light"><i class="bi bi-download"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $files->links('pagination::bootstrap-5') }}
    @else
        <div class="text-center py-4 text-muted small">
            <i class="bi bi-inbox fs-2 mb-2"></i>
            <div>Belum ada file di dalam folder ini.</div>
        </div>
    @endif
</div>
@endsection