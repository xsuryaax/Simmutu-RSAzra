<header class="mb-3">
    <div class="page-header px-4 py-2 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-3">
            {{-- Burger Button for Mobile --}}
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3" style="color: #25396f;"></i>
            </a>

            {{-- Title Section --}}
            <div class="page-header-left d-none d-md-block">
                <h3 class="mb-0">@yield('title')</h3>
                <span class="text-muted small">@yield('subtitle', 'Sistem Informasi Manajemen Mutu Terintegrasi')</span>
            </div>

            {{-- Mobile Compact Title --}}
            <div class="page-header-left d-block d-md-none">
                <h5 class="mb-0">@yield('title')</h5>
            </div>
        </div>

        <div class="page-header-right">
            <div class="dropdown user-dropdown">
                <button class="btn btn-user-profile dropdown-toggle d-flex align-items-center gap-2 p-1 pe-3" type="button" id="userMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar-wrapper shadow-sm">
                        <img src="{{ asset('img/profile.jpg') }}" alt="Profile" class="user-avatar-img">
                    </div>
                    <span class="user-name-text d-none d-lg-inline">👋 Hello, {{ Auth::user()->nama_lengkap }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3 p-2" aria-labelledby="userMenuButton" style="min-width: 200px; border-radius: 15px;">
                    {{-- User Details inside dropdown for mobile --}}
                    <li class="d-lg-none px-3 py-3 border-bottom mb-2 bg-light rounded-top">
                         <div class="small text-muted mb-1">Signed in as:</div>
                         <div class="fw-bold text-primary">{{ Auth::user()->nama_lengkap }}</div>
                    </li>
                    <li>
                        <form method="POST" action="/logout" id="logout-form">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger py-2 rounded-3 d-flex align-items-center gap-2">
                                <i class="bi bi-box-arrow-right fs-5"></i> 
                                <span class="fw-600">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>