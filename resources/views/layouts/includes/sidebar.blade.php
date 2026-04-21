<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2 sidebar-brand">
                    <div class="logo-img">
                        <img src="{{ asset('assets/logo/azra-logo.png') }}" alt="logo RS Azra">
                    </div>
                    <div class="logo" height="30">
                        SIMMUTU
                    </div>
                </div>
                <a href="#" class="sidebar-toggle-btn" title="Tutup/Buka Sidebar">
                    <i class="bi bi-list fs-4"></i>
                </a>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                @php
                    $menuGroups = config('menu');
                @endphp

                @foreach ($menuGroups as $groupKey => $group)
                    @php
                        // Check if user has permission for at least one menu in this group
                        $hasGroupAccess = false;
                        foreach ($group['menus'] as $m) {
                            if (auth()->user()->hasPermission($m['key'])) {
                                $hasGroupAccess = true;
                                break;
                            }
                        }
                    @endphp

                    @if ($hasGroupAccess)
                        <li class="sidebar-title">{{ $group['title'] }}</li>

                        @if ($groupKey === 'menu_utama')
                            {{-- Special handling for Dashboard as it's the first item --}}
                            @php $dashboard = collect($group['menus'])->firstWhere('key', 'dashboard'); @endphp
                            @if (auth()->user()->hasPermission('dashboard'))
                                <li class="sidebar-item {{ Request::is('/') ? 'active' : '' }}">
                                    <a href="{{ url('/') }}" class='sidebar-link'>
                                        <div class="sidebar-icon">
                                            <i class="bi bi-grid-fill"></i>
                                        </div>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                            @endif

                            {{-- Indikator Mutu Submenu --}}
                            @php
                                $indikatorMenus = [
                                    'master_indikator',
                                    'kamus_indikator',
                                    'laporan_analis',
                                    'laporan_validator',
                                    'analisa_data',
                                ];
                                $hasIndikatorAccess = false;
                                foreach ($indikatorMenus as $k) {
                                    if (auth()->user()->hasPermission($k)) {
                                        $hasIndikatorAccess = true;
                                        break;
                                    }
                                }
                            @endphp

                            @if ($hasIndikatorAccess)
                                <li
                                    class="sidebar-item has-sub {{ request()->is('laporan-analis*') || request()->is('laporan-validator*') || request()->is('kamus-indikator*') || request()->is('master-indikator*') || request()->is('analisa-data*') || request()->is('pdsa*') ? 'active' : '' }}">
                                    <a href="#" class="sidebar-link">
                                        <div class="sidebar-icon">
                                            <i class="bi bi-file-earmark-medical-fill"></i>
                                        </div>
                                        <span>Indikator Mutu</span>
                                    </a>
                                    <ul class="submenu">
                                        @if (auth()->user()->hasPermission('master_indikator'))
                                            <li
                                                class="submenu-item {{ request()->is('master-indikator*') ? 'active' : '' }}">
                                                <a href="{{ route('master-indikator.index') }}" class="submenu-link"
                                                    style="text-decoration: none;">Master Indikator</a>
                                            </li>
                                        @endif
                                        @if (auth()->user()->hasPermission('kamus_indikator'))
                                            <li
                                                class="submenu-item {{ request()->is('kamus-indikator*') ? 'active' : '' }}">
                                                <a href="{{ route('kamus-indikator.index') }}" class="submenu-link"
                                                    style="text-decoration: none;">Profil Indikator</a>
                                            </li>
                                        @endif
                                        @if (auth()->user()->hasPermission('laporan_analis'))
                                            <li
                                                class="submenu-item {{ request()->is('laporan-analis*') ? 'active' : '' }}">
                                                <a href="{{ route('laporan-analis.index') }}" class="submenu-link"
                                                    style="text-decoration: none;">Pengisian Indikator</a>
                                            </li>
                                        @endif
                                        @if (auth()->user()->hasPermission('laporan_validator'))
                                            <li
                                                class="submenu-item {{ request()->is('laporan-validator*') ? 'active' : '' }}">
                                                <a href="{{ route('laporan-validator.index') }}" class="submenu-link"
                                                    style="text-decoration: none;">Validasi Indikator</a>
                                            </li>
                                        @endif
                                        @if (auth()->user()->hasPermission('analisa_data'))
                                            <li
                                                class="submenu-item {{ request()->is('analisa-data*') ? 'active' : '' }}">
                                                <a href="{{ route('analisa-data.index') }}" class="submenu-link"
                                                    style="text-decoration: none;">Analisa Indikator</a>
                                            </li>
                                        @endif
                                        {{-- PDSA NEW LOCATION --}}
                                        @if (auth()->user()->hasPermission('pdsa'))
                                            <li class="submenu-item {{ request()->is('pdsa*') ? 'active' : '' }}">
                                                <a href="{{ url('/pdsa') }}" class="submenu-link"
                                                    style="text-decoration: none;">PDSA</a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif

                            {{-- SPM (Standar Pelayanan Minimal) --}}
                            <li
                                class="sidebar-item has-sub {{ request()->is('master-spm*') || request()->is('laporan-spm*') || request()->is('analisa-spm*') ? 'active' : '' }}">
                                <a href="#" class="sidebar-link">
                                    <div class="sidebar-icon">
                                        <i class="bi bi-clipboard-check-fill"></i>
                                    </div>
                                    <span>SPM</span>
                                </a>
                                <ul class="submenu">
                                    <li class="submenu-item {{ request()->is('master-spm*') ? 'active' : '' }}">
                                        <a href="{{ route('master-spm.index') }}" class="submenu-link"
                                            style="text-decoration: none;">Master SPM</a>
                                    </li>
                                    <li class="submenu-item {{ request()->is('laporan-spm*') ? 'active' : '' }}">
                                        <a href="{{ route('laporan-spm.index') }}" class="submenu-link"
                                            style="text-decoration: none;">Pengisian SPM</a>
                                    </li>
                                    <li class="submenu-item {{ request()->is('analisa-spm*') ? 'active' : '' }}">
                                        <a href="{{ route('analisa-spm.index') }}" class="submenu-link"
                                            style="text-decoration: none;">Analisa SPM</a>
                                    </li>
                                </ul>
                            </li>
                        @elseif($groupKey === 'manajemen_data_mutu')
                            <li
                                class="sidebar-item has-sub {{ request()->is('dimensi-mutu*') || request()->is('periode-analisis-data*') || request()->is('periode-pengumpulan-data*') || request()->is('penyajian-data*') || request()->is('metode-pengumpulan-data*') || request()->is('kategori-imprs*') || request()->is('jenis-indikator*') ? 'active' : '' }}">

                                <a href="#" class="sidebar-link">
                                    <div class="sidebar-icon">
                                        <i class="bi bi-stack"></i>
                                    </div>
                                    <span>Indikator Mutu</span>
                                </a>

                                <ul class="submenu">
                                    @foreach ($group['menus'] as $m)
                                        @if (auth()->user()->hasPermission($m['key']))
                                            <li
                                                class="submenu-item {{ request()->is(explode('.', $m['route'])[0] . '*') ? 'active' : '' }}">
                                                <a href="{{ route($m['route']) }}" class="submenu-link"
                                                    style="text-decoration: none;">{{ $m['label'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @elseif($groupKey === 'pengaturan')
                            @foreach ($group['menus'] as $m)
                                @if (auth()->user()->hasPermission($m['key']))
                                    <li
                                        class="sidebar-item {{ Request::is(explode('.', $m['route'])[0] . '*') ? 'active' : '' }}">
                                        <a href="{{ route($m['route']) }}" class='sidebar-link'>
                                            <div class="sidebar-icon">
                                                <i
                                                    class="bi {{ $m['key'] == 'manajemen_user' ? 'bi-person-fill-gear' : ($m['key'] == 'manage_role' ? 'bi-person-fill-check' : ($m['key'] == 'manajemen_unit' ? 'bi-buildings-fill' : ($m['key'] == 'periode_mutu' ? 'bi-calendar-event-fill' : 'bi-key-fill'))) }}"></i>
                                            </div>
                                            <span>{{ $m['label'] }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
