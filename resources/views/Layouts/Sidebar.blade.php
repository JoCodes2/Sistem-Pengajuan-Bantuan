        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="index.html" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <img src="{{ asset('assets/assets/logopemprov.png') }}" alt="Logo" class="img-fluid" width="50" height="50">
                    </span>
                    <span class="text-start app-brand-text fw-bold ms-2 ">
                        <small>Dinas Kelautan</small><br>
                        <small>dan Perikanan</small><br>
                        <small>Provinsi Sulawesi Tengah</small>
                    </span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                @if (auth()->user()->role == 'super admin')
                    <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                        <a href="/dashboard" class="menu-link">
                            <i class="menu-icon fa-solid fa-house"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('prosedur') ? 'active' : '' }}">
                        <a href="/prosedur" class="menu-link">
                            <i class="menu-icon fa-solid fa-file"></i> <!-- Ganti dengan ikon kertas -->
                            <div data-i18n="Analytics">Prosedur</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('group') ? 'active' : '' }}">
                        <a href="/group" class="menu-link">
                            <i class="menu-icon fa-brands fa-42-group"></i>
                            <div data-i18n="Analytics">Kelompok</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('member-group') ? 'active' : '' }}">
                        <a href="/member-group" class="menu-link">
                            <i class="menu-icon fa-solid fa-people-group"></i>
                            <div data-i18n="Analytics">Anggota Kelompok</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('submissions') ? 'active' : '' }}">
                        <a href="/submissions" class="menu-link">
                            <i class="menu-icon fa-solid fa-code-pull-request"></i>
                            <div data-i18n="Analytics">Pengajuan</div>
                        </a>
                    </li>
                    <li class="menu-item {{ request()->is('user') ? 'active' : '' }}">
                        <a href="/user" class="menu-link">
                            <i class="menu-icon fa-solid fa-user"></i>
                            <div data-i18n="Analytics">Pengguna</div>
                        </a>
                    </li>
                @else
                    <li class="menu-item {{ request()->is('disposision') ? 'active' : '' }}">
                        <a href="/disposision" class="menu-link">
                            <i class="menu-icon fa-solid fa-list-check"></i>
                            <div data-i18n="Analytics">Disposisi</div>
                        </a>
                    </li>

                @endif
            </ul>
        </aside>
        <!-- / Menu -->
