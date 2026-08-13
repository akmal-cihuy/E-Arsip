@extends('layouts.app')
@section('page_title', 'Edit Pengguna')

@section('content')
<div class="card card-custom p-4 mx-auto" style="max-width: 750px;">
    <h5 class="fw-bold mb-4">Ubah Informasi Pengguna: {{ $user->name }}</h5>

    @if($errors->any())
        <div class="alert alert-danger py-2 small">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nomor Identitas / NIP</label>
                <input type="text" name="identity_number" class="form-control" value="{{ old('identity_number', $user->identity_number) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Role Pengguna</label>
                <select name="role" class="form-select" required>
                    <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Departemen</label>
                <input type="text" name="department" class="form-control" value="{{ old('department', $user->department) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Jabatan</label>
                <input type="text" name="position" class="form-control" value="{{ old('position', $user->position) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Nomor Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-semibold">Reset Password (Kosongkan jika tidak diganti)</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••">
            </div>
            <div class="col-12 text-end mt-4">
                <a href="{{ route('users.index') }}" class="btn btn-light me-2">Batal</a>
                <button type="submit" class="btn btn-orange">Perbarui Pengguna</button>
            </div>
        </div>
    </form>
</div>
@endsection