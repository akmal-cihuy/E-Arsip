<header class="top-navbar">
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm btn-light d-lg-none" id="sidebarToggle">
            <i class="bi bi-list fs-5"></i>
        </button>
        <div class="fw-bold fs-5 text-dark">
            @yield('page_title', 'Dashboard')
        </div>
    </div>

    <div class="d-flex align-items-center gap-4">
        <!-- User Dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <div class="me-2 text-end d-none d-sm-block">
                    <div class="fw-bold small">{{ auth()->user()->name }}</div>
                    <div class="text-muted" style="font-size: 0.75rem;">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
                <div class="bg-orange text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; background-color: var(--primary-orange);">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>