<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - E-Arsip Perusahaan</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-orange: #FF6B00;
            --primary-orange-hover: #e05e00;
            --primary-orange-light: #FFF0E6;
            --secondary-orange: #FF8C42;
            --bg-light: #F8F9FA;
            --text-dark: #212529;
            --border-color: #E9ECEF;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
        }

        /* Sidebar Styling */
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #ffffff;
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px;
            font-weight: 700;
            color: var(--primary-orange);
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-nav {
            padding: 15px 10px;
            list-style: none;
            margin: 0;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 4px;
        }

        .sidebar-nav .nav-link {
            color: #6c757d;
            font-weight: 500;
            padding: 10px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            color: var(--primary-orange);
            background-color: var(--primary-orange-light);
            font-weight: 600;
        }

        .sidebar-nav .nav-link i {
            font-size: 1.2rem;
        }

        /* Main Content Wrapper */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar */
        .top-navbar {
            height: 70px;
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 0 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Button Orange */
        .btn-orange {
            background-color: var(--primary-orange);
            color: #ffffff;
            border: none;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
        }

        .btn-orange:hover {
            background-color: var(--primary-orange-hover);
            color: #ffffff;
        }

        .btn-outline-orange {
            border: 1px solid var(--primary-orange);
            color: var(--primary-orange);
            background: transparent;
            font-weight: 600;
        }

        .btn-outline-orange:hover {
            background-color: var(--primary-orange);
            color: #ffffff;
        }

        /* Card & UI Clean Elements */
        .card-custom {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-custom:hover {
            box-shadow: 0 6px 16px rgba(255, 107, 0, 0.08);
        }

        .stat-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            background-color: var(--primary-orange-light);
            color: var(--primary-orange);
        }

        .badge-orange {
            background-color: var(--primary-orange-light);
            color: var(--primary-orange);
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
        }

        /* Pagination Orange Custom */
        .page-link {
            color: var(--text-dark);
        }
        .page-item.active .page-link {
            background-color: var(--primary-orange);
            border-color: var(--primary-orange);
        }

        @media (max-width: 991.98px) {
            #sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #sidebar.active {
                margin-left: 0;
            }
            #main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content Area -->
    <div id="main-content">
        @include('layouts.navbar')

        <div class="p-4 flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>

        <footer class="bg-white border-top py-3 text-center text-muted small">
            &copy; 2026 E-Arsip &bull; proyek siswa PKL SMK Mahaputra Cerdas Utama
        </footer>
    </div>

    <!-- Bootstrap 5 JS Bundle & Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    @stack('scripts')
</body>
</html>