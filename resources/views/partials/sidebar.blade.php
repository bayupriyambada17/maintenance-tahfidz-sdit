<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{{ url('assets/img/sdit.png') }}" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">SDIT Daarul Ulum</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex {{ Request::is('my-profile*') ? 'btn btn-primary' : '' }}">
            <div class="image">
                @if (auth()->user()->foto == null)
                    <img src="{{ url('assets/img/foto_default.jpg') }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ url('storage/' . auth()->user()->foto) }}" class="img-circle elevation-2"
                        alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="{{ url('/my-profile') }}" class="d-block"
                    style="{{ Request::is('my-profile*') ? 'color: white' : '' }}">My Profile</a>
            </div>
        </div>
        @if (Request::is('my-profile*'))
            <hr style="background-color:dimgray">
        @endif

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">



                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li
                    class="nav-item {{ Request::is('users*') || Request::is('roles*') || Request::is('kelas*') || Request::is('siswa*') || Request::is('surat*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::is('users*') || Request::is('roles*') || Request::is('kelas*') || Request::is('siswa*') || Request::is('surat*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Database
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (auth()->user()->hasRole('admin'))
                            <li class="nav-item">
                                <a href="{{ url('/users') }}"
                                    class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                                    <i class="fa fa-users nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('guru.index') }}"
                                    class="nav-link {{ Request::routeIs('guru*') ? 'active' : '' }}">
                                    <i class="fa fa-users nav-icon"></i>
                                    <p>Guru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/roles') }}"
                                    class="nav-link {{ Request::is('roles*') ? 'active' : '' }}">
                                    <i class="fas fa-user-tag nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/kelas') }}"
                                    class="nav-link {{ Request::is('kelas*') ? 'active' : '' }}">
                                    <i class="fas fa-hospital-alt nav-icon"></i>
                                    <p>Kelas</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('/surat') }}"
                                    class="nav-link {{ Request::is('surat*') ? 'active' : '' }}">
                                    <i class="fas fa-quran nav-icon"></i>
                                    <p>Surat</p>
                                </a>
                            </li>
                        @endif


                        <li class="nav-item">
                            <a href="{{ url('/siswa') }}"
                                class="nav-link {{ Request::is('siswa*') ? 'active' : '' }}">
                                <i class="fas fa-user-graduate nav-icon"></i>
                                <p>Siswa</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="nav-item {{ Request::is('pencatatan-harian*') || Request::is('ujian-tahfidz*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::is('pencatatan-harian*') || Request::is('ujian-tahfidz*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>
                            Tahfidz
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/pencatatan-harian') }}"
                                class="nav-link {{ Request::is('pencatatan-harian*') ? 'active' : '' }}">
                                <i class="fas fa-journal-whills nav-icon"></i>
                                <p>Pencatatan Harian</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/ujian-tahfidz') }}"
                                class="nav-link {{ Request::is('ujian-tahfidz*') ? 'active' : '' }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Ujian Tahfidz</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="nav-item user-panel {{ Request::is('tahsin-harian*') || Request::is('ujian-tahsin*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::is('tahsin-harian*') || Request::is('ujian-tahsin*') ? 'active' : '' }}">
                        <i class="nav-icon fab fa-readme"></i>
                        <p>
                            Tahsin
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/tahsin-harian') }}"
                                class="nav-link {{ Request::is('tahsin-harian*') ? 'active' : '' }}">
                                <i class="fas fa-book-reader nav-icon"></i>
                                <p>Tahsin Harian</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/ujian-tahsin') }}"
                                class="nav-link {{ Request::is('ujian-tahsin*') ? 'active' : '' }}">
                                <i class="fab fa-react nav-icon"></i>
                                <p>Ujian Tahsin</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Log Out
                        </p>
                    </a>
                </li>



            </ul>
        </nav>

    </div>
    <!-- /.sidebar -->
</aside>
