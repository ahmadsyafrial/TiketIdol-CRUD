<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - TiketIdol')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F1F5F9;
            color: #1E293B;
        }

        .admin-sidebar {
            width: 260px;
            background-color: #0F172A;
            min-height: 100vh;
            color: #94A3B8;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }

        .admin-content {
            margin-left: 260px;
            padding: 24px;
            min-height: 100vh;
        }

        .sidebar-brand {
            padding: 24px 20px;
            font-size: 1.25rem;
            font-weight: 800;
            color: #FFFFFF;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .sidebar-menu {
            list-style: none;
            padding: 16px 12px;
            margin: 0;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #94A3B8;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover, .sidebar-link.active {
            color: #FFFFFF;
            background-color: #1E293B;
        }

        .sidebar-link.active {
            background-color: #0064D2;
            color: #FFFFFF;
        }

        .card-admin {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }

        @media (max-width: 991px) {
            .admin-sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }
            .admin-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <i class="bi bi-shield-shaded text-primary fs-3"></i>
            <div>
                <div>Tiket<span style="color:#FF2D78;">Idol</span></div>
                <div class="small fw-normal text-secondary" style="font-size: 0.7rem;">ADMIN DASHBOARD CRUD</div>
            </div>
        </a>

        <ul class="sidebar-menu">
            <li class="sidebar-heading px-3 py-2 small text-uppercase fw-bold text-secondary" style="font-size: 0.7rem;">Manajemen Konser</li>
            <li>
                <a href="{{ route('admin.concerts.index') }}" class="sidebar-link {{ request()->routeIs('admin.concerts.*') ? 'active' : '' }}">
                    <i class="bi bi-music-note-list fs-5"></i>
                    <span>Daftar Konser (CRUD)</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.concerts.create') }}" class="sidebar-link">
                    <i class="bi bi-plus-circle fs-5"></i>
                    <span>Tambah Konser Baru</span>
                </a>
            </li>

            <li class="sidebar-heading px-3 py-2 mt-3 small text-uppercase fw-bold text-secondary" style="font-size: 0.7rem;">Transaksi & Tiket</li>
            <li>
                <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt-cutoff fs-5"></i>
                    <span>Pesanan & Pembayaran</span>
                </a>
            </li>

            <li class="sidebar-heading px-3 py-2 mt-3 small text-uppercase fw-bold text-secondary" style="font-size: 0.7rem;">Situs Publik</li>
            <li>
                <a href="{{ route('home') }}" target="_blank" class="sidebar-link text-info">
                    <i class="bi bi-box-arrow-up-right fs-5"></i>
                    <span>Buka Web Pemesanan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('booking.check') }}" target="_blank" class="sidebar-link text-warning">
                    <i class="bi bi-search fs-5"></i>
                    <span>Cek E-Ticket Publik</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Content Area -->
    <div class="admin-content">
        <!-- Top Navbar -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <div>
                <h4 class="fw-bold mb-0 text-dark">@yield('page-title', 'Dashboard')</h4>
                <div class="text-secondary small">Kelola data konser, tier kategori tiket, dan riwayat pesanan tiket idol.</div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="bi bi-eye me-1"></i> Lihat Toko
                </a>
                <span class="badge bg-primary px-3 py-2 rounded-pill">
                    <i class="bi bi-person-fill me-1"></i> Admin Tiket Idol
                </span>
            </div>
        </div>

        <!-- Global Alert Notifications -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
