<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Arsip Perusahaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --primary-orange: #FF6B00; --primary-orange-light: #FFF0E6; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #EFEADF; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 100%; max-width: 440px; border-radius: 16px; border: 1px solid #E9ECEF; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .btn-orange { background-color: var(--primary-orange); color: white; font-weight: 600; }
        .btn-orange:hover { background-color: #e05e00; color: white; }
    </style>
</head>
<body>
    <div class="container p-3">
        <div class="card login-card mx-auto bg-white p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center " >
                    <img src="{{asset('image/logo1.png')}}" alt="logo" class="mb-2" style="width: 350px; height: auto;">
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger py-2 small border-0">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder=" E-mail" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Password" required>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">Ingat Saya</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-orange w-100 py-2 mb-3">Masuk ke Sistem</button>
            </form>
        </div>
    </div>
</body>
</html>