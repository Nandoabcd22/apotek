<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apotek Management System - Toko Obat Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --danger-color: #dc3545;
            --light-bg: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        /* Navbar */
        .navbar {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            font-weight: 700;
        }

        .navbar-brand i {
            margin-right: 8px;
        }

        .nav-link {
            color: #4b5563 !important;
            font-weight: 500;
            margin: 0 8px;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 60px 0 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 12px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .hero p {
            font-size: 1rem;
            margin-bottom: 25px;
            opacity: 0.95;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.5;
        }
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero .btn {
            font-weight: 600;
            padding: 12px 30px;
            margin: 8px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-light:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .btn-outline-light:hover {
            background-color: white;
            color: var(--primary-color) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* Section Title */
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1f36;
            margin-bottom: 10px;
        }

        .section-title p {
            font-size: 1rem;
            color: #6b7280;
        }

        /* Product Card */
        .product-card {
            border: none;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }

        .product-image {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8f0ff 100%);
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--primary-color);
        }

        .product-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1f36;
            margin-bottom: 10px;
            line-height: 1.4;
            min-height: 50px;
            display: flex;
            align-items: center;
        }

        .product-info {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 15px;
            flex-grow: 1;
        }

        .product-info p {
            margin: 5px 0;
            display: flex;
            justify-content: space-between;
        }

        .product-price {
            background: linear-gradient(135deg, #e0e7ff 0%, #f0f4ff 100%);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }

        .price-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .product-button {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .product-button:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            color: white;
        }

        /* Products Container */
        .products-container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            margin-bottom: 40px;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: white;
            padding: 50px 0 20px;
            margin-top: auto;
        }

        footer h5 {
            color: white;
            font-weight: 700;
            margin-bottom: 15px;
        }

        footer p {
            color: #9ca3af;
            line-height: 1.6;
        }

        footer a {
            color: #60a5fa;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: white;
        }

        .footer-divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 30px 0;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #9ca3af;
        }

        /* Pagination */
        .pagination {
            justify-content: center;
        }

        .page-link {
            color: var(--primary-color);
            border-color: #e5e7eb;
        }

        .page-link:hover {
            color: white;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-state p {
            color: #9ca3af;
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .section-title h2 {
                font-size: 1.5rem;
            }

            .products-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-hospital"></i> Apotek
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-house-door"></i> Beranda
                        </a>
                    </li>
                    @if(auth()->check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="nav-link btn p-0" style="border: none; background: none;">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Daftar
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Apotek Management System</h1>
                <p>Kelola stok obat-obatan dengan mudah dan efisien. Belanja obat berkualitas dari rumah Anda.</p>
                <div>
                    @if(!auth()->check())
                        <a href="{{ route('register') }}" class="btn btn-light">
                            <i class="bi bi-person-plus"></i> Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-light">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="py-5">
        <div class="container">
            <!-- Section Title -->
            <div class="section-title">
                <h2>Obat-Obatan Pilihan</h2>
                <p>Daftar obat-obatan terpopuler dan terlaris di apotek kami</p>
            </div>

            <!-- Products Container -->
            <div class="products-container">
                <div class="row">
                    @forelse($obats as $obat)
                    <div class="col-6 col-md-4 col-lg-3 mb-4">
                        <div class="product-card">
                            <div class="product-image">
                                <i class="bi bi-capsule"></i>
                            </div>
                            <div class="product-body">
                                <h5 class="product-name">{{ $obat->nama_obat }}</h5>
                                <div class="product-info">
                                    <p>
                                        <span><strong>Jenis</strong></span>
                                        <span>{{ $obat->jenis }}</span>
                                    </p>
                                    <p>
                                        <span><strong>Satuan</strong></span>
                                        <span>{{ $obat->satuan }}</span>
                                    </p>
                                    <p>
                                        <span><strong>Stok</strong></span>
                                        <span class="badge bg-success">{{ $obat->stok }} pcs</span>
                                    </p>
                                </div>
                                <div class="product-price">
                                    <span class="price-value">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</span>
                                </div>
                                <button class="product-button w-100">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada data obat yang tersedia</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                @if($obats->hasPages())
                <div class="mt-5">
                    {{ $obats->links() }}
                </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5><i class="bi bi-hospital"></i> Apotek Management</h5>
                    <p>Sistem manajemen apotek terpercaya untuk memenuhi kebutuhan kesehatan Anda dengan layanan terbaik.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Layanan Kami</h5>
                    <ul style="list-style: none; padding-left: 0;">
                        <li><a href="#">Jual Beli Obat</a></li>
                        <li><a href="#">Konsultasi Farmasi</a></li>
                        <li><a href="#">Pengiriman Cepat</a></li>
                        <li><a href="#">Garansi Keaslian</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Informasi</h5>
                    <ul style="list-style: none; padding-left: 0;">
                        <li><i class="bi bi-telephone"></i> <a href="tel:+62-xxx-xxx">+62-XXX-XXXX</a></li>
                        <li><i class="bi bi-envelope"></i> <a href="mailto:info@apotek.com">info@apotek.com</a></li>
                        <li><i class="bi bi-geo-alt"></i> Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="footer-divider"></div>
            <div class="footer-bottom">
                <p>&copy; 2026 Apotek Management System. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
