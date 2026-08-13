@extends('layouts.app')
@section('page_title', 'Riwayat Aktivitas Log')

@section('content')
<div class="card card-custom p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Audit Trail & Log Aktivitas</h5>
            <p class="text-muted small mb-0">Catatan jejak rekam akses pengguna, unduhan, dan pengunggahan berkas.</p>
        </div>
    </div>

    <!-- Filter Riwayat -->
    <form action="{{ route('activities.index') }}" method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="user_id" class="form-select form-select-sm">
                <option value="">Semua User</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="activity" class="form-control form-control-sm" placeholder="Jenis aktivitas (e.g. Upload, Download)" value="{{ request('activity') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-orange btn-sm w-100"><i class="bi bi-filter"></i> Saring</button>
            <a href="{{ route('activities.index') }}" class="btn btn-light btn-sm"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-3 small">
            <thead class="table-light">
                <tr>
                    <th>Waktu</th>
                    <th>Nama Pengguna</th>
                    <th>Aktivitas</th>
                    <th>Detail Keterangan</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $log)
                    <tr>
                        <td class="text-muted">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        <td class="fw-bold">{{ $log->user->name ?? 'Tamu/System' }}</td>
                        <td><span class="badge badge-orange">{{ $log->activity }}</span></td>
                        <td>
                            <div>{{ $log->description ?? '-' }}</div>
                            @if($log->document)
                                <a href="{{ route('documents.show', $log->document->id) }}" class="text-decoration-none small text-primary">Lihat Terkait</a>
                            @endif
                        </td>
                        <td><code>{{ $log->ip_address }}</code></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat aktivitas tercatat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $activities->links('pagination::bootstrap-5') }}
</div>
@endsection