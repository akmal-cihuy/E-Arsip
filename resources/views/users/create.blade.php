@extends('layouts.app')
@section('page_title', 'Tambah Pengguna Baru')

@section('content')
<div class="card card-custom p-4 mx-auto" style="max-width: 750px;">
    <h5 class="fw-bold mb-4">Registrasi Akun Baru</h5>

    @if($errors->any())
        <div class="alert alert-danger py-2 small">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Email Perusahaan <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nomor Identitas / NIP</label>
                <input type="text" name="identity_number" class="form-control" value="{{ old('identity_number') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Role Pengguna <span class="text-danger">*</span></label>
                <select name="role" class="form-select" required>
                    <option value="petugas">Petugas</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Password Sementara <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-12 text-end mt-4">
                <a href="{{ route('users.index') }}" class="btn btn-light me-2">Batal</a>
                <button type="submit" class="btn btn-orange">Daftarkan Akun</button>
            </div>
        </div>
    </form>
</div>
@endsection