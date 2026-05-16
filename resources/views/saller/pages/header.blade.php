@php
    $gs = \App\Models\Generalsetting::getSettings();
    $siteName = $gs->website_name ?? ($gs->site_name ?? 'Shahzadi Mart');
@endphp

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<div class="top-navbar d-flex justify-content-between align-items-center w-100">

        <div class="d-flex align-items-center gap-3">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div class="navbar-brand d-flex align-items-center gap-2">
                @if($gs->header_logo)
                    <img src="{{ asset($gs->header_logo) }}" alt="Logo" style="height: 30px; width: auto; object-fit: contain;">
                @else
                    <i class="bi bi-shop"></i>
                @endif
                <span class="d-none d-sm-inline">{{ $siteName }} <strong>SELLER</strong></span>
            </div>
        </div>

        <div class="user-profile-dropdown dropdown">
            <div class="d-flex align-items-center gap-2 cursor-pointer dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                <div class="text-end d-none d-sm-block">
                    <p class="mb-0 font-w600" style="font-size: 14px; color: #333;">{{ auth()->user()->name }}</p>
                    <small class="text-muted" style="font-size: 11px;">Seller Profile</small>
                </div>
                <img src="{{ auth()->user()->photo ? asset(auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=ff3e6c&color=fff' }}" 
                     alt="Profile" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #eee;">
            </div>
            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2" style="border-radius: 12px; min-width: 200px;">
                <li class="px-3 py-2 border-bottom">
                    <p class="mb-0 font-w600" style="color: #333;">{{ auth()->user()->name }}</p>
                    <small class="text-muted">{{ auth()->user()->email }}</small>
                </li>
                <li><a class="dropdown-item py-2" href="{{ route('saller.profile.index') }}"><i class="bi bi-person me-2"></i> My Profile</a></li>
                <li><a class="dropdown-item py-2" href="{{ route('saller.profile.index') }}#password-section"><i class="bi bi-shield-lock me-2"></i> Change Password</a></li>
                <li><a class="dropdown-item py-2" href="{{ route('saller.profile.edit') }}"><i class="bi bi-gear me-2"></i> Settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item py-2 text-danger" href="{{ route('saller.logout') }}">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
