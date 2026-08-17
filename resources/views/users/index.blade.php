@extends('layouts.app')
@section('page_title', 'Manajemen Pengguna')

@section('content')
<div class="card card-custom p-4 mb-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Daftar Akun Pengguna</h5>
            <p class="text-muted small mb-0">Kelola hak akses dan staf operasional sistem E-Arsip.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-orange btn-sm">
            <i class="bi bi-person-plus me-1"></i> Tambah User Baru
        </a>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('users.index') }}" method="GET" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau email" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select form-select-sm">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-orange btn-sm w-100">
                <i class="bi bi-filter me-1"></i> Filter
            </button>
        </div>
    </form>

    <!-- Table Section -->
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3 small">
            <thead class="table-light">
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $user->name }}</div>
                            <span class="text-muted" style="font-size: 0.75rem;">Terdaftar: {{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'bg-dark' : 'badge-orange' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-light" title="Edit Data">
                                    <i class="bi bi-pencil text-dark"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-light" title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                            <i class="bi {{ $user->is_active ? 'bi-person-slash text-warning' : 'bi-person-check text-success' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus akun ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light" title="Hapus Akun">
                                            <i class="bi bi-trash text-danger"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-person-x fs-2 d-block mb-1"></i>
                            Tidak ada data pengguna yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection