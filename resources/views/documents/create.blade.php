@extends('layouts.app')
@section('page_title', 'Upload Dokumen Baru')

@section('content')
<div class="card card-custom p-4 mx-auto" style="max-width: 800px;">
    <h5 class="fw-bold mb-4">Formulir Pengarsipan Dokumen</h5>

    @if($errors->any())
        <div class="alert alert-danger py-2 small">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nama Dokumen <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Kontrak Kerjasama Vendor" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nomor Surat/Dokumen <span class="text-danger">*</span></label>
                <input type="text" name="document_number" class="form-control" placeholder="Contoh: 045/DIR-PK/VIII/2026" value="{{ old('document_number') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Kategori <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Folder</label>
                <select name="folder_id" class="form-select">
                    <option value="">Pilih Folder</option>
                    @foreach($folders as $folder)
                        <option value="{{ $folder->id }}" {{ old('folder_id') == $folder->id ? 'selected' : '' }}>{{ $folder->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-semibold">Status Dokumen <span class="text-danger">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="aktif">Aktif</option>
                    <option value="rahasia">Rahasia</option>
                    <option value="arsip_lama">Arsip Lama</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Tanggal Dokumen <span class="text-danger">*</span></label>
                <input type="date" name="document_date" class="form-control" value="{{ old('document_date', date('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Berkas File (PDF, DOCX, XLS, JPG, dll) <span class="text-danger">*</span></label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label small fw-semibold">Deskripsi / Ringkasan Isi</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Tuliskan catatan atau keterangan ringkas...">{{ old('description') }}</textarea>
            </div>
            <div class="col-12 mt-4 text-end">
                <a href="{{ route('documents.index') }}" class="btn btn-light me-2">Batal</a>
                <button type="submit" class="btn btn-orange">Simpan Dokumen</button>
            </div>
        </div>
    </form>
</div>
@endsection