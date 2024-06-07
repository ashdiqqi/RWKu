<div class="sidebar">
    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if(Auth::user()->level_id == 1 || Auth::user()->level_id == 2 )
            <li class="nav-item has-treeview {{ ($activeMenu == 'warga')? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ ($activeSubMenu == 'warga')? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Data Warga
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/warga') }}" class="nav-link {{ ($activeSubMenu == 'warga_list')? 'active' : '' }}">
                            <i class="far nav-icon"></i>
                            <p>Daftar Warga</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/keluarga') }}" class="nav-link {{ ($activeSubMenu == 'keluarga_list')? 'active' : '' }}">
                            <i class="far nav-icon"></i>
                            <p>Daftar Keluarga</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/kepemilikan') }}" class="nav-link {{ ($activeSubMenu == 'kepemilikan_list')? 'active' : '' }}">
                            <i class="far nav-icon"></i>
                            <p>Data Kepemilikan</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if(Auth::user()->level_id == 1 || Auth::user()->level_id == 2 || Auth::user()->level_id == 3 )
            <li class="nav-item has-treeview {{ ($activeMenu == 'kegiatan')? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ ($activeSubMenu == 'kegiatan')? 'active' : '' }}">
                    <i class="nav-icon fas fa-list-alt"></i>
                    <p>
                        Data kegiatan
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/kegiatan') }}" class="nav-link {{ ($activeSubMenu == 'kegiatan_list')? 'active' : '' }}">
                            <i class="far nav-icon"></i>
                            <p>Daftar kegiatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/dokumentasi') }}" class="nav-link {{ ($activeSubMenu == 'dokumentasi_list')? 'active' : '' }}">
                            <i class="far nav-icon"></i>
                            <p>Dokumentasi Kegiatan</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if(Auth::user()->level_id == 1 || Auth::user()->level_id == 2 || Auth::user()->level_id == 3 )
            <li class="nav-item">
                <a href="{{ url('/keuangan') }}" class="nav-link {{ ($activeMenu == 'keuangan')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Data Keuangan</p>
                </a>
            </li>
            @endif
            @if(Auth::user()->level_id == 1)
            <li class="nav-item">
                <a href="{{ url('/permintaan') }}" class="nav-link {{ ($activeMenu == 'permintaan')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>Permintaan</p>
                </a>
            </li>
            @endif
            @if(Auth::user()->level_id == 1 || Auth::user()->level_id == 2 || Auth::user()->level_id == 3 )
            <li class="nav-item">
                <a href="{{ url('/keluargaku') }}" class="nav-link {{ ($activeMenu == 'keluargaku')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Keluargaku</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/profile') }}" class="nav-link {{ ($activeMenu == 'profile')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-user-circle"></i>
                    <p>Profil</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/logout') }}" class="nav-link {{ ($activeMenu == 'logout')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Keluar</p>
                </a>
            </li>
            @endif
        </ul>
    </nav>
  </div>
  