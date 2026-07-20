<div class="sidenav-menu">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="{{ asset('assets/images/logo.png') }}" alt="logo" /></span>
            <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" /></span>
        </span>

        <span class="logo logo-dark">
            <span class="logo-lg"><img src="{{ asset('assets/images/logo-black.png') }}" alt="dark logo" /></span>
            <span class="logo-sm"><img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo" /></span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-on-hover">
        <span class="btn-on-hover-icon"></span>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-offcanvas">
        <i class="ti ti-menu-4 align-middle"></i>
    </button>

    <div class="scrollbar" data-simplebar="">
        <div id="user-profile-settings" class="sidenav-user" style="background: url({{ asset('assets/images/user-bg-pattern.svg') }})">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="position-relative d-inline-block text-center cursor-pointer mb-2" onclick="triggerQuickAvatarUpload()" title="Klik untuk ganti foto profil">
                        <img src="{{ Auth::user()?->avatar_url ?? asset('assets/images/users/user-1.jpg') }}" alt="user-image" class="rounded-circle avatar-md object-fit-cover user-avatar-img" />
                    </div>
                    <div>
                        <span class="sidenav-user-name fw-bold d-block">{{ Auth::user()->name ?? 'User' }}</span>
                        <span class="fs-12 fw-semibold opacity-75 d-block">{{ Auth::user()->email ?? '' }}</span>
                    </div>
                </div>
                <div>
                    <a class="dropdown-toggle drop-arrow-none link-reset sidenav-user-set-icon" data-bs-toggle="dropdown" data-bs-offset="0,12" href="#!" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-settings fs-24 align-middle ms-1"></i>
                    </a>

                    <div class="dropdown-menu">
                        <!-- Header -->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0" data-lang="welcome-back">Welcome back!</h6>
                        </div>

                        <!-- My Profile -->
                        <a href="{{ route('page', 'profile-page') }}" class="dropdown-item">
                            <i class="ti ti-user-circle me-1 fs-lg align-middle"></i>
                            <span class="align-middle" data-lang="profile">Profile</span>
                        </a>

                        <!-- Settings -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-settings-2 me-1 fs-lg align-middle"></i>
                            <span class="align-middle" data-lang="account-settings">Account Settings</span>
                        </a>

                        <!-- Lock -->
                        <a href="{{ route('page', 'auth-lock-screen') }}" class="dropdown-item">
                            <i class="ti ti-lock me-1 fs-lg align-middle"></i>
                            <span class="align-middle" data-lang="lock-screen">Lock Screen</span>
                        </a>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form" class="d-none">
                            @csrf
                        </form>
                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();" class="dropdown-item text-danger fw-semibold">
                            <i class="ti ti-logout me-1 fs-lg align-middle"></i>
                            <span class="align-middle" data-lang="log-out">Log Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!--- Sidenav Menu -->
        <div id="sidenav-menu">
            <ul class="side-nav">
                @if(isset($sidebarMenus) && $sidebarMenus->isNotEmpty())
                    @foreach($sidebarMenus as $menu)
                        @include('layouts.partials.sidebar-menu-item', ['menu' => $menu])
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- Sidenav Menu End -->