<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background: #F8F9FA; min-height: 100vh; display: flex; align-items: center; justify-content: center; }</style>
</head>
<body>
    <div class="text-center p-4">
        <h1 class="display-1 fw-bold" style="color: #FF6B00;">404</h1>
        <h4 class="fw-bold mb-2">Halaman Tidak Ditemukan</h4>
        <p class="text-muted">Dokumen atau tautan yang Anda tuju telah dipindahkan atau dihapus.</p>
        <a href="{{ route('dashboard') }}" class="btn text-white mt-3" style="background-color: #FF6B00;">Kembali ke Dashboard</a>
    </div>
</body>
</html>