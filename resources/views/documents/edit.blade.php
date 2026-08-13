@extends('layouts.app')
@section('page_title', 'Edit File')

@section('content')
<div class="card card-custom p-4 mx-auto" style="max-width: 800px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Edit Metadata File</h5>
        <a href="{{ route('documents.show', $document->id) }}" class="btn btn-sm btn-light"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-2 small">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documents.update', $document->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nama File</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $document->name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Kategori</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $document->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Folder</label>
                <select name="folder_id" class="form-select">
                    <option value="">(Tanpa Folder / Root)</option>
                    @foreach($folders as $folder)
                        <option value="{{ $folder->id }}" {{ old('folder_id', $document->folder_id) == $folder->id ? 'selected' : '' }}>{{ $folder->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Status File</label>
                <select name="status" class="form-select" required>
                    <option value="aktif" {{ old('status', $document->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="rahasia" {{ old('status', $document->status) == 'rahasia' ? 'selected' : '' }}>Rahasia</option>
                    <option value="arsip_lama" {{ old('status', $document->status) == 'arsip_lama' ? 'selected' : '' }}>Arsip Lama</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Tanggal File</label>
                <input type="date" name="document_date" class="form-control" value="{{ old('document_date', $document->document_date->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">File Saat Ini</label>
                <input type="text" class="form-control bg-light" value="{{ $document->file_name }} ({{ $document->formatted_size }})" disabled>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $document->description) }}</textarea>
            </div>
            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-orange">Perbarui Data</button>
            </div>
        </div>
    </form>
</div>
@endsection