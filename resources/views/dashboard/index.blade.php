@extends('layouts.app')
@section('page_title', 'Dashboard Utama')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Ringkasan Pengarsipan</h4>
        <p class="text-muted small mb-0">Pantau seluruh penyimpanan dan aktivitas dokumen secara langsung.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('documents.create') }}" class="btn btn-orange btn-sm">
            <i class="bi bi-cloud-arrow-up me-1"></i> Upload Dokumen
        </a>
        <a href="{{ route('folders.index') }}" class="btn btn-outline-orange btn-sm">
            <i class="bi bi-folder-plus me-1"></i> Tambah Folder
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card card-custom p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Total Dokumen</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ number_format($totalDocs) }}</h3>
                </div>
                <div class="stat-icon-box"><i class="bi bi-file-earmark-text"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-custom p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Total Folder</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ number_format($totalFolders) }}</h3>
                </div>
                <div class="stat-icon-box"><i class="bi bi-folder"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-custom p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Total Kategori</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ number_format($totalCategories) }}</h3>
                </div>
                <div class="stat-icon-box"><i class="bi bi-tags"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card card-custom p-3 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted small fw-semibold">Penyimpanan Terpakai</span>
                    <h3 class="fw-bold mt-1 mb-0">{{ $formattedStorage }}</h3>
                </div>
                <div class="stat-icon-box"><i class="bi bi-hdd-network"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Visualizations -->
{{-- <div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card card-custom p-4 h-100">
            <h6 class="fw-bold mb-3">Statistik Upload Dokumen (Tahun {{ date('Y') }})</h6>
            <canvas id="monthlyDocsChart" height="130"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-custom p-4 h-100">
            <h6 class="fw-bold mb-3">Proporsi per Kategori</h6>
            <div style="position: relative; height: 230px;">
                <canvas id="categoryDoughnutChart"></canvas>
            </div>
        </div>
    </div>
</div> --}}

<!-- Recent Documents & Activities -->
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0">Dokumen Terbaru</h6>
                <a href="{{ route('documents.index') }}" class="small text-decoration-none fw-semibold" style="color: var(--primary-orange);">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th>Nama Dokumen</th>
                            <th>Kategori</th>
                            <th>Ukuran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($recentDocs as $doc)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $doc->name }}</div>
                                    <span class="text-muted" style="font-size: 0.75rem;">#{{ $doc->document_number }}</span>
                                </td>
                                <td><span class="badge badge-orange">{{ $doc->category->name }}</span></td>
                                <td>{{ $doc->formatted_size }}</td>
                                <td>
                                    <a href="{{ route('documents.show', $doc->id) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('documents.download', $doc->id) }}" class="btn btn-sm btn-light"><i class="bi bi-download"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">Belum ada dokumen yang diunggah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-custom p-4">
            <h6 class="fw-bold mb-3">Aktivitas Terbaru</h6>
            <div class="list-group list-group-flush small">
                @forelse($recentActivities as $act)
                    <div class="list-group-item px-0 py-2 border-0 border-bottom">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">{{ $act->user->name }}</span>
                            <span class="text-muted" style="font-size: 0.75rem;">{{ $act->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-muted">{{ $act->activity }}: {{ $act->description }}</div>
                    </div>
                @empty
                    <div class="text-center py-3 text-muted">Belum ada aktivitas tercatat.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
{{-- 
@push('scripts')
<script>
    // 1. Line Chart
    const ctxMonthly = document.getElementById('monthlyDocsChart').getContext('2d');
    new Chart(ctxMonthly, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Dokumen',
                data: {!! json_encode($chartMonthlyData) !!},
                borderColor: '#FF6B00',
                backgroundColor: 'rgba(255, 107, 0, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
        }
    });

    // // 2. Doughnut Chart
    // const ctxCategory = document.getElementById('categoryDoughnutChart').getContext('2d');
    // new Chart(ctxCategory, {
    //     type: 'doughnut',
    //     data: {
    //         labels: {!! json_encode($chartCategoryLabels) !!},
    //         datasets: [{
    //             data: {!! json_encode($chartCategoryData) !!},
    //             backgroundColor: ['#FF6B00', '#FF8C42', '#FFB380', '#212529', '#6C757D', '#ADB5BD']
    //         }]
    //     },
    //     options: {
    //         responsive: true,
    //         maintainAspectRatio: false,
    //         plugins: { legend: { position: 'bottom' } }
    //     }
    // });
</script>
@endpush --}}