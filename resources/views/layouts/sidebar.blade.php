<nav id="sidebar">
    <div class="sidebar-brand">
        <img src="{{asset('image/logo2.png')}}" alt="logo" class="mb-2" style="width: 180px; height: auto;">
    </div>
    <ul class="sidebar-nav">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('folders.index') }}" class="nav-link {{ request()->routeIs('folders.*') ? 'active' : '' }}">
                <i class="bi bi-folder-fill"></i>
                <span>Folder</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('documents.index') }}" class="nav-link {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span>File</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i>
                <span>Kategori</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('documents.create') }}" class="nav-link">
                <i class="bi bi-cloud-arrow-up-fill"></i>
                <span>Upload File</span>
            </a>
        </li>

        <li class="nav-divider my-3 border-top"></li>
        
        <li class="nav-item">
            <a href="{{ route('activities.index') }}" class="nav-link {{ request()->routeIs('activities.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Aktivitas</span>
            </a>
        </li>

        @if(auth()->user()->isAdmin())
            <li class="nav-divider my-3 border-top"></li>
            <li class="px-3 text-muted small fw-bold text-uppercase mb-2">Administrasi</li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Manajemen User</span>
                </a>
            </li>
        @endif

        <li class="nav-item mt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"  class="nav-link text-danger w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </li>
    </ul>
</nav>