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

        <div class="page-header-right d-flex align-items-center gap-3">
            <span class="user-name-text d-none d-lg-inline fw-bold" style="color: #25396f; font-size: 1.1rem;">👋 Hallo, {{ Auth::user()->nama_lengkap }}</span>
            <form method="POST" action="/logout" id="logout-form" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm d-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow-sm border-0 text-white" style="background-color: #007774;">
                    <i class="bi bi-box-arrow-right"></i> 
                    <span class="fw-bold">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>