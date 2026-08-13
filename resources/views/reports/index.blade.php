@extends('layouts.app')
@section('page_title', 'Laporan Pengarsipan')

@section('content')
<!-- Ringkasan Statistik Laporan -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-custom p-3">
            <span class="text-muted small fw-semibold">Total Arsip Terfilter</span>
            <h4 class="fw-bold mt-1 mb-0">{{ number_format($totalDocs) }} Berkas</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom p-3">
            <span class="text-muted small fw-semibold">Total Frekuensi Download</span>
            <h4 class="fw-bold mt-1 mb-0">{{ number_format($totalDownloads) }} Kali</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-custom p-3">
            <span class="text-muted small fw-semibold">Total Bobot Data</span>
            <h4 class="fw-bold mt-1 mb-0">{{ number_format($totalSize / 1048576, 2) }} MB</h4>
        </div>
    </div>
</div>

<div class="card card-custom p-4 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h5 class="fw-bold mb-1">Filter Laporan Dokumen</h5>
            <p class="text-muted small mb-0">Sesuaikan rentang tanggal dan klasifikasi data arsip.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ request()->fullUrlWithQuery(['export' => 'csv']) }}" class="btn btn-outline-orange btn-sm">
                <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export Excel / CSV
            </a>
            <button onclick="window.print()" class="btn btn-light btn-sm">
                <i class="bi bi-printer me-1"></i> Cetak PDF
            </button>
        </div>
    </div>

    <!-- Filter Bar -->
    <form action="{{ route('reports.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <label class="small fw-semibold">Dari Tanggal</label>
            <input type="date" name="date_start" class="form-control form-control-sm" value="{{ request('date_start') }}">
        </div>
        <div class="col-md-3">
            <label class="small fw-semibold">Sampai Tanggal</label>
            <input type="date" name="date_end" class="form-control form-control-sm" value="{{ request('date_end') }}">
        </div>
        <div class="col-md-2">
            <label class="small fw-semibold">Kategori</label>
            <select name="category_id" class="form-select form-select-sm">
                <option value="">Semua</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="small fw-semibold">Folder</label>
            <select name="folder_id" class="form-select form-select-sm">
                <option value="">Semua</option>
                @foreach($folders as $folder)
                    <option value="{{ $folder->id }}" {{ request('folder_id') == $folder->id ? 'selected' : '' }}>{{ $folder->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-orange btn-sm w-100">Terapkan</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3 small">
            <thead class="table-light">
                <tr>
                    <th>No. Dokumen</th>
                    <th>Nama Dokumen</th>
                    <th>Kategori</th>
                    <th>Folder</th>
                    <th>Uploader</th>
                    <th>Tgl Arsip</th>
                    <th>Unduhan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                    <tr>
                        <td class="fw-bold">{{ $doc->document_number }}</td>
                        <td>{{ $doc->name }}</td>
                        <td><span class="badge badge-orange">{{ $doc->category->name }}</span></td>
                        <td>{{ $doc->folder->name ?? 'Root' }}</td>
                        <td>{{ $doc->user->name }}</td>
                        <td>{{ $doc->document_date->format('d/m/Y') }}</td>
                        <td>{{ $doc->download_count }}x</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4 text-muted">Tidak ditemukan data pada filter terpilih.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $documents->links('pagination::bootstrap-5') }}
</div>
@endsection