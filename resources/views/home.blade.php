<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Management System</title>
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

        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        }

        .card-img-top {
            background-color: #f0f0f0;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--primary-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .page-header {
            background: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        footer {
            background-color: #1f2937;
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="bi bi-hospital"></i> Apotek Management System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    </li>
                    @if(auth()->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="nav-link btn" style="border: none; background: none;">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </navbar>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Apotek Management System</h1>
            <p>Kelola stok obat-obatan dengan mudah dan efisien</p>
            <div>
                @if(!auth()->check())
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg me-2">
                        <i class="bi bi-person-plus"></i> Daftar Sebagai Pelanggan
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-house-door"></i> Ke Dashboard
                    </a>
                @endif
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="page-header">
            <h2>Obat-Obatan yang Terjual</h2>
            <p class="text-muted">Daftar obat-obatan terpopuler di apotek kami</p>
        </div>

        <div class="row">
            @forelse($obats as $obat)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-img-top">
                        <i class="bi bi-capsule"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $obat->nama_obat }}</h5>
                        <p class="card-text text-muted small">
                            <strong>Jenis:</strong> {{ $obat->jenis }}<br>
                            <strong>Satuan:</strong> {{ $obat->satuan }}<br>
                            <strong>Stok:</strong> {{ $obat->stok }}
                        </p>
                        <p class="card-text">
                            <strong class="text-primary">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</strong>
                        </p>
                        <a href="#" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-center text-muted py-5">Belum ada data obat</p>
            </div>
            @endforelse
        </div>

        @if($obats->hasPages())
        <div class="d-flex justify-content-center">
            {{ $obats->links() }}
        </div>
        @endif
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-hospital"></i> Apotek Management System</h5>
                    <p class="text-muted">Sistem manajemen apotek terpercaya untuk kebutuhan Anda</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted">&copy; 2026 Apotek Management System. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
