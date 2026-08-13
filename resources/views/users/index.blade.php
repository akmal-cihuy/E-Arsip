@extends('layouts.app')
@section('page_title', 'Manajemen Pengguna')

@section('content')
<div class="card card-custom p-4 mb-4">
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
    <form action="{{ route('users.index') }}" method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama, email" value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="role" class="form-select form-select-sm">
                <option value="">Semua Role</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ request('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-orange btn-sm w-100">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3 small">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $user->name }}</div>
                            <span class="text-muted" style="font-size: 0.75rem;">Terdaftar: {{ $user->created_at->format('d M Y') }}</span>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->identity_number ?? '-' }}</td>
                        <td>
                            <div>{{ $user->department ?? '-' }}</div>
                            <span class="text-muted" style="font-size: 0.75rem;">{{ $user->position ?? '-' }}</span>
                        </td>
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
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-light text-warning" title="Toggle Status">
                                            <i class="bi {{ $user->is_active ? 'bi-person-slash' : 'bi-person-check' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus akun ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $users->links('pagination::bootstrap-5') }}
</div>
@endsection