@extends('layouts.app')
@section('page_title', 'Profil Saya')

@section('content')
<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <h5 class="fw-bold mb-4">Pengaturan Akun & Profil</h5>

            @if($errors->any())
                <div class="alert alert-danger py-2 small">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <div class="bg-orange text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-3" style="width: 70px; height: 70px; background-color: var(--primary-orange);">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">{{ $user->name }}</h6>
                        <span class="badge badge-orange">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="col-12 mt-4 pt-3 border-top">
                        <h6 class="fw-bold mb-3">Ganti Kata Sandi</h6>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" placeholder="••••••••">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" placeholder="••••••••">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="••••••••">
                    </div>

                    <div class="col-12 text-end mt-4">
                        <button type="submit" class="btn btn-orange">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection