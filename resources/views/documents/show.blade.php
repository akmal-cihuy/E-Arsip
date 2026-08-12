@extends('layouts.app')
@section('page_title', 'Detail Dokumen')

@section('content')
<div class="row g-4">
    <!-- Info Metadata -->
    <div class="col-lg-5">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <span class="badge badge-orange">{{ strtoupper($document->file_type) }}</span>
                <span class="badge bg-secondary">{{ ucfirst($document->status) }}</span>
            </div>
            <h4 class="fw-bold mb-1">{{ $document->name }}</h4>
            <p class="text-muted small mb-3">Nomor: <strong>{{ $document->document_number }}</strong></p>

            <table class="table table-sm small">
                <tr><th class="text-muted">Kategori</th><td>{{ $document->category->name }}</td></tr>
                <tr><th class="text-muted">Folder</th><td>{{ $document->folder->name ?? 'Root' }}</td></tr>
                <tr><th class="text-muted">Ukuran File</th><td>{{ $document->formatted_size }}</td></tr>
                <tr><th class="text-muted">Pemilik File</th><td>{{ $document->user->name }}</td></tr>
                <tr><th class="text-muted">Tanggal Dokumen</th><td>{{ $document->document_date->format('d F Y') }}</td></tr>
                <tr><th class="text-muted">Tanggal Upload</th><td>{{ $document->created_at->format('d/m/Y H:i') }}</td></tr>
                <tr><th class="text-muted">Diunduh</th><td>{{ $document->download_count }} kali</td></tr>
            </table>

            <div class="mb-3">
                <label class="small fw-bold text-muted">Deskripsi:</label>
                <p class="small bg-light p-2 rounded">{{ $document->description ?? 'Tidak ada deskripsi tambahan.' }}</p>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('documents.download', $document->id) }}" class="btn btn-orange">
                    <i class="bi bi-download me-1"></i> Unduh Berkas
                </a>
            </div>
        </div>
    </div>

    <!-- Pratinjau Dokumen -->
    <div class="col-lg-7">
        <div class="card card-custom p-3 h-100">
            <h6 class="fw-bold mb-3">Pratinjau Dokumen</h6>
            @if(strtolower($document->file_type) === 'pdf')
                <iframe src="{{ route('documents.preview', $document->id) }}" width="100%" height="550px" class="rounded border"></iframe>
            @elseif(in_array(strtolower($document->file_type), ['jpg', 'jpeg', 'png']))
                <div class="text-center">
                    <img src="{{ route('documents.preview', $document->id) }}" class="img-fluid rounded border" style="max-height: 550px;">
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-file-earmark-lock display-3 mb-3"></i>
                    <h6>Format file ({{ strtoupper($document->file_type) }}) tidak dapat ditampilkan langsung.</h6>
                    <p class="small">Silakan unduh berkas untuk melihat isinya.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection