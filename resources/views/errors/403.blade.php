<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: #F8F9FA; min-height: 100vh; display: flex; align-items: center; justify-content: center; }</style>
</head>
<body>
    <div class="text-center p-4">
        <h1 class="display-1 fw-bold text-danger">403</h1>
        <h4 class="fw-bold mb-2">Akses Terlarang</h4>
        <p class="text-muted">Anda tidak memiliki hak akses (role) untuk membuka halaman ini.</p>
        <a href="{{ route('dashboard') }}" class="btn btn-dark mt-3">Kembali ke Dashboard</a>
    </div>
</body>
</html>