<div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <div class="d-flex justify-content-between">
            <div class="logo">
                <a href="index.html" class="text-decoration-none">
                    <h4 class="m-0 fw-bold" style="color: #25396f;">SIMMUTU RS AZRA</h4>
                </a>
            </div>
            <div class="toggler">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu Utama</li>

            <li class="sidebar-item">
                <a href="index.html" class='sidebar-link'>
                    <i class="bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="index.html" class='sidebar-link'>
                    <i class="bi-file-bar-graph-fill"></i>
                    <span>Laporan dan Analisis</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="index.html" class='sidebar-link'>
                    <i class="bi-book-fill"></i>
                    <span>Kamus Indikator Mutu</span>
                </a>
            </li>

            <li class="sidebar-title">Menu</li>
            <li class="sidebar-item has-sub">
                <a href="#" class='sidebar-link d-flex align-items-center gap-2'>
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Manajemen Data Mutu</span>
                </a>

                <ul class="submenu">
                    <li class="sidebar-item has-sub">
                        <a href="#" class='sidebar-link d-flex align-items-center gap-2'>
                            <i class="bi bi-folder-fill"></i>
                            <span>Master Indikator Mutu</span>
                        </a>

                        <ul class="submenu">

                            <li class="submenu-item">
                                <a href="{{ route('master-indikator.index') }}" class="d-flex align-items-center gap-2">
                                    <i class="bi bi-list-check"></i>
                                    <span>Master Indikator</span>
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{route('cakupan-data.index')}}" class="d-flex align-items-center gap-2">
                                    <i class="bi bi-bounding-box"></i>
                                    <span>Cakupan Data</span>
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('dimensi-mutu.index') }}" class="d-flex align-items-center gap-2">
                                    <i class="bi bi-star"></i>
                                    <span>Dimensi Mutu</span>
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('frekuensi-analisis-data.index') }}" class="d-flex align-items-center gap-2">
                                    <i class="bi bi-bar-chart"></i>
                                    <span>Frekuensi Analisa Data</span>
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('frekuensi-pengumpulan-data.index') }}" class="d-flex align-items-center gap-2">
                                    <i class="bi bi-calendar-check"></i>
                                    <span>Frekuensi Pengumpulan Data</span>
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('interpretasi-data.index') }}" class="d-flex align-items-center gap-2">
                                    <i class="bi bi-lightbulb"></i>
                                    <span>Interpretasi Data</span>
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('metodologi-analisis-data.index') }}" class="d-flex align-items-center gap-2">
                                    <i class="bi bi-pie-chart"></i>
                                    <span>Metodologi Analisa Data</span>
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('metodologi-pengumpulan-data.index') }}" class="d-flex align-items-center gap-2">
                                    <i class="bi bi-clipboard-data"></i>
                                    <span>Metodologi Pengumpulan Data</span>
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('publikasi-data.index') }}" class="d-flex align-items-center gap-2">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <span>Publikasi Data</span>
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
            </li>

            <li class="sidebar-title">Pengaturan</li>

            <li class="sidebar-item">
                <a href="index.html" class='sidebar-link'>
                    <i class="bi-collection-fill"></i>
                    <span>Database</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="index.html" class='sidebar-link'>
                    <i class="bi-house-fill"></i>
                    <span>Unit</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="index.html" class='sidebar-link'>
                    <i class="bi-people-fill"></i>
                    <span>Manajemen User</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="index.html" class='sidebar-link'>
                    <i class="bi-shield-lock-fill"></i>
                    <span>Manajemen Role</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('manajemen-unit.index') }}" class='sidebar-link'>
                    <i class="bi-diagram-3-fill"></i>
                    <span>Manajemen Unit</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="index.html" class='sidebar-link'>
                    <i class="bi-shield-fill-check"></i>
                    <span>Hak Akses</span>
                </a>
            </li>

        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>