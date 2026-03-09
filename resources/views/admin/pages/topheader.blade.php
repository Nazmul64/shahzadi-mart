<header id="topbar">
    <div class="topbar-left">
        <button id="menuToggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        <div class="topbar-search d-none d-md-flex">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search...">
        </div>
    </div>

    <div class="topbar-right">
        <a href="#" class="topbar-icon-btn">
            <i class="bi bi-globe"></i>
        </a>
        <a href="#" class="topbar-icon-btn">
            <i class="bi bi-envelope"></i>
            <span class="topbar-badge">0</span>
        </a>
        <a href="#" class="topbar-icon-btn">
            <i class="bi bi-cart"></i>
            <span class="topbar-badge">0</span>
        </a>
        <a href="#" class="topbar-icon-btn">
            <i class="bi bi-person"></i>
            <span class="topbar-badge">0</span>
        </a>
        <a href="#" class="topbar-icon-btn">
            <i class="bi bi-display"></i>
            <span class="topbar-badge">1</span>
        </a>

        <div class="dropdown">
            <div class="topbar-user dropdown-toggle" id="userDrop" data-bs-toggle="dropdown">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" alt="Admin">
                <span class="topbar-user-name d-none d-sm-block">{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDrop"
                style="font-size:13px; min-width:160px; border-color:var(--border);">
                <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="dropdown-item text-danger" type="submit">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
