<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Apotek Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
        }
        
        body {
            background-color: #f8fafc;
        }
        
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            padding-top: 20px;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 10px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .badge {
            padding: 6px 12px;
        }
        
        .table {
            background: white;
        }
        
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.25);
        }
        
        .page-header {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 sidebar">
                <div class="text-white mb-4 ps-3">
                    <h4><i class="bi bi-hospital"></i> Apotek</h4>
                    <small>Management System</small>
                </div>
                <ul class="nav flex-column">
                    @unless(auth()->user()->isApoteker() || auth()->user()->isPelanggan())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    @endunless

                    @if(auth()->user()->isAdmin())
                    <!-- Admin Menu -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="bi bi-person-badge"></i> Daftar Apoteker
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.obats*') ? 'active' : '' }}" href="{{ route('admin.obats.index') }}">
                            <i class="bi bi-capsule"></i> Data Obat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.suppliers*') ? 'active' : '' }}" href="{{ route('admin.suppliers.index') }}">
                            <i class="bi bi-building"></i> Supplier
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.pelanggans*') ? 'active' : '' }}" href="{{ route('admin.pelanggans.index') }}">
                            <i class="bi bi-people"></i> Daftar Pelanggan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.penjualans*') ? 'active' : '' }}" href="{{ route('admin.penjualans.index') }}">
                            <i class="bi bi-bag-check"></i> Report Penjualan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.pembelians*') ? 'active' : '' }}" href="{{ route('admin.pembelians.index') }}">
                            <i class="bi bi-cart3"></i> Daftar Pembelian
                        </a>
                    </li>

                    @elseif(auth()->user()->isApoteker())
                    <!-- Apoteker Menu -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('apoteker.obats.index') ? 'active' : '' }}" href="{{ route('apoteker.obats.index') }}">
                            <i class="bi bi-capsule"></i> Data Obat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('apoteker.obats.search') ? 'active' : '' }}" href="{{ route('apoteker.obats.search') }}">
                            <i class="bi bi-search"></i> Cari & Filter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('apoteker.obats.expired') ? 'active' : '' }}" href="{{ route('apoteker.obats.expired') }}">
                            <i class="bi bi-exclamation-triangle"></i> Obat Kadaluarsa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('apoteker.penjualans.index') ? 'active' : '' }}" href="{{ route('apoteker.penjualans.index') }}">
                            <i class="bi bi-bag-check"></i> Penjualan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('apoteker.penjualans.history') ? 'active' : '' }}" href="{{ route('apoteker.penjualans.history') }}">
                            <i class="bi bi-clock-history"></i> History Penjualan
                        </a>
                    </li>

                    @elseif(auth()->user()->isPelanggan())
                    <!-- Pelanggan Menu -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pelanggan.obats*') ? 'active' : '' }}" href="{{ route('pelanggan.obats.index') }}">
                            <i class="bi bi-capsule"></i> Daftar Obat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pelanggan.penjualans*') ? 'active' : '' }}" href="{{ route('pelanggan.penjualans.index') }}">
                            <i class="bi bi-bag-check"></i> Pembelian Saya
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 px-4 py-4">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light mb-4">
                    <div class="container-fluid">
                        <span class="navbar-text">
                            @yield('breadcrumb')
                        </span>
                        <div class="ms-auto d-flex align-items-center gap-3">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle"></i> {{ auth()->user()->name ?? 'Guest' }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><h6 class="dropdown-header">{{ auth()->user()->email ?? '' }}</h6></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="bi bi-box-arrow-right"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Alert Messages -->
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
