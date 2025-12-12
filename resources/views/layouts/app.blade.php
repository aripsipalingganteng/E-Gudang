
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('adminlte3/dist/img/AdminLTELogo.png') }}" 
             alt="E-Gudang Logo" 
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">E-Gudang</span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('adminlte3/dist/img/user2-160x160.jpg') }}" 
                     class="img-circle elevation-2" 
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Administrator' }}</a>
                <span class="text-sm text-success">
                    <i class="fas fa-circle"></i> 
                    {{ Auth::user()->role ?? 'Super Admin' }}
                </span>
            </div>
        </div>
        
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" 
                       type="search" 
                       placeholder="Search" 
                       aria-label="Search">
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
                <!-- Dashboard -->
                <li class="nav-item {{ request()->routeIs('dashboard') ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <!-- Super Admin Menu -->
                @if(Auth::check() && Auth::user()->role == 'super_admin')
                <li class="nav-header">SUPER ADMIN</li>
                
                <!-- User Management -->
                <li class="nav-item {{ request()->is('super-admin/user*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('super-admin/user*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('super-admin.user.index') }}" 
                               class="nav-link {{ request()->routeIs('super-admin.user.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('super-admin.user.create') }}" 
                               class="nav-link {{ request()->routeIs('super-admin.user.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Category Management -->
                <li class="nav-item {{ request()->is('super-admin/category*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('super-admin/category*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Kategori
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('super-admin.category.index') }}" 
                               class="nav-link {{ request()->routeIs('super-admin.category.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Kategori</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                <!-- Admin & Super Admin Menu -->
                <li class="nav-header">INVENTORY</li>
                
                <!-- Product Management -->
                <li class="nav-item {{ request()->is('*/product*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('*/product*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Barang
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(Auth::check() && Auth::user()->role == 'super_admin')
                        <li class="nav-item">
                            <a href="{{ route('super-admin.product.index') }}" 
                               class="nav-link {{ request()->routeIs('super-admin.product.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Barang</p>
                            </a>
                        </li>
                        @elseif(Auth::check() && Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.product.index') }}" 
                               class="nav-link {{ request()->routeIs('admin.product.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Barang</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                
                <!-- Reports -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Laporan</p>
                    </a>
                </li>
                
                <!-- Settings -->
                <li class="nav-header">SETTINGS</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>
                
                <!-- Help -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Bantuan</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>