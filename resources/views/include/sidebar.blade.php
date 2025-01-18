<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="grey">

            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('logo.png') }}" alt="CV. Citra Perkasa Logo" style="width: 50px; height: auto;">
                <b>CV. Citra Perkasa</b>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>

        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ Route::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Data Admin</h4>
                </li>
                <li class="nav-item {{ Route::is('admin') ? 'active' : '' }}">
                    <a href="{{ route('admin') }}">
                        <i class="fas fa-users"></i>
                        <p>Data Admin</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Data Penjualan</h4>
                </li>
                <li class="nav-item {{ Route::is('penjualan') ? 'active' : '' }}">
                    <a href="{{ route('penjualan') }}">
                        <i class="far fa-credit-card"></i>
                        <p>Data Penjualan</p>
                    </a>
                </li>
                <li class="nav-item {{ Route::is('rekap') ? 'active' : '' }}">
                    <a href="{{ route('home') }}">
                        <i class="far fa-folder-open"></i>
                        <p>Rekapitulasi Data Tahunan</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Tools</h4>
                </li>
                <li class="nav-item {{ Route::is('analisa') ? 'active' : '' }}">
                    <a href="{{ route('analisa') }}">
                        <i class="far fa-chart-bar"></i>
                        <p>Analisa</p>
                    </a>
                </li>

                {{-- <li class="nav-item {{ Route::is('analisa.*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#sidebarLayouts">
                        <i class="far fa-chart-bar"></i>
                        <p>Analisis</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sidebarLayouts">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('analisa') }}">
                                    <span class="sub-item">Analisa</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('analisaAll') }}">
                                    <span class="sub-item">Analisa</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
