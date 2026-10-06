<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TiketIdol.com - Pemesanan Tiket Konser K-Pop & Idol Resmi')</title>
    <meta name="description" content="Pesan tiket konser idol favoritmu seperti BABYMONSTER, aespa, NewJeans, IU resmi, mudah, dan aman di TiketIdol.com layaknya tiket.com.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #0064D2;
            --primary-hover: #0050A8;
            --primary-light: #EBF4FE;
            --accent-pink: #FF2D78;
            --accent-purple: #8B5CF6;
            --dark-navy: #0B132B;
            --dark-card: #141E33;
            --light-bg: #F5F7FA;
            --border-color: #E2E8F0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar-tiket {
            background: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            padding: 14px 0;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar-brand-logo {
            font-weight: 800;
            font-size: 1.45rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .navbar-brand-logo .idol-badge {
            background: linear-gradient(135deg, #FF2D78 0%, #8B5CF6 100%);
            color: #fff;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .nav-link-custom {
            font-weight: 600;
            color: #475569;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            color: var(--primary);
            background-color: var(--primary-light);
        }

        /* Buttons */
        .btn-tiket-primary {
            background: linear-gradient(135deg, #0064D2 0%, #0050A8 100%);
            color: #ffffff;
            font-weight: 700;
            border: none;
            padding: 10px 22px;
            border-radius: 10px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(0, 100, 210, 0.25);
        }
        .btn-tiket-primary:hover {
            background: linear-gradient(135deg, #0050A8 0%, #003E84 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 100, 210, 0.35);
        }

        .btn-tiket-accent {
            background: linear-gradient(135deg, #FF2D78 0%, #E11D48 100%);
            color: #ffffff;
            font-weight: 700;
            border: none;
            padding: 10px 22px;
            border-radius: 10px;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(255, 45, 120, 0.25);
        }
        .btn-tiket-accent:hover {
            background: linear-gradient(135deg, #E11D48 0%, #BE123C 100%);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 45, 120, 0.35);
        }

        /* Cards & Shadows */
        .card-custom {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            border-color: #CBD5E1;
        }

        /* Step Progress */
        .step-progress-wrapper {
            background: #FFFFFF;
            border-bottom: 1px solid #E2E8F0;
            padding: 16px 0;
            margin-bottom: 24px;
        }
        .step-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            color: #94A3B8;
            font-size: 0.9rem;
        }
        .step-item.active {
            color: var(--primary);
        }
        .step-item.completed {
            color: #10B981;
        }
        .step-circle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            background: #E2E8F0;
            color: #64748B;
        }
        .step-item.active .step-circle {
            background: var(--primary);
            color: #FFFFFF;
        }
        .step-item.completed .step-circle {
            background: #10B981;
            color: #FFFFFF;
        }
        .step-divider {
            height: 2px;
            background: #E2E8F0;
            flex-grow: 1;
            margin: 0 12px;
        }
        .step-divider.active {
            background: #10B981;
        }

        /* Perforated Ticket Card Style */
        .ticket-wrapper {
            background: #FFFFFF;
            border-radius: 16px;
            border: 1px solid #E2E8F0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        .ticket-notch-left, .ticket-notch-right {
            position: absolute;
            width: 24px;
            height: 24px;
            background-color: #F8FAFC;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            border: 1px solid #E2E8F0;
        }
        .ticket-notch-left {
            left: -13px;
        }
        .ticket-notch-right {
            right: -13px;
        }

        /* Footer */
        .footer-tiket {
            background: #0B132B;
            color: #94A3B8;
            padding: 50px 0 25px 0;
            margin-top: auto;
        }
        .footer-title {
            color: #FFFFFF;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }
        .footer-link {
            color: #94A3B8;
            text-decoration: none;
            transition: color 0.2s;
            display: inline-block;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        .footer-link:hover {
            color: #FFFFFF;
        }

        /* Countdown Box */
        .countdown-box {
            background: #FFFBEB;
            border: 1px solid #FDE68A;
            color: #B45309;
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Print styles */
        @media print {
            .navbar-tiket, .footer-tiket, .btn-print-hide, .breadcrumb, .alert {
                display: none !important;
            }
            body {
                background: #FFFFFF !important;
            }
            .ticket-wrapper {
                box-shadow: none !important;
                border: 2px dashed #000000 !important;
                page-break-inside: avoid;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-tiket">
        <div class="container">
            <a class="navbar-brand-logo" href="{{ route('home') }}">
                <i class="bi bi-ticket-perforated-fill text-primary" style="font-size: 1.8rem;"></i>
                <span>Tiket<span style="color: #FF2D78;">Idol</span></span>
                <span class="idol-badge">K-POP OFFICIAL</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="bi bi-list fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto ms-lg-4 mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-music-note-beamed me-1"></i> Konser Idol
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('booking.check') ? 'active' : '' }}" href="{{ route('booking.check') }}">
                            <i class="bi bi-search me-1"></i> Cek Pesanan / E-Ticket
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('home') }}#panduan">
                            <i class="bi bi-question-circle me-1"></i> Cara Pesan
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('booking.check') }}" class="btn btn-outline-primary btn-sm px-3 py-2 fw-semibold rounded-pill">
                        <i class="bi bi-ticket-detailed me-1"></i> My Bookings
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-dark btn-sm px-3 py-2 fw-semibold rounded-pill">
                        <i class="bi bi-shield-lock me-1"></i> Admin Panel
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Global Alerts -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <strong>Pemberitahuan:</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                <strong>Perhatian:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer (tiket.com style) -->
    <footer class="footer-tiket">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-ticket-perforated-fill text-info fs-3"></i>
                        <span class="fs-4 fw-bold text-white">Tiket<span style="color: #FF2D78;">Idol</span>.com</span>
                    </div>
                    <p class="text-secondary small leading-relaxed">
                        Platform resmi pemesanan tiket konser K-Pop & Idol di Indonesia. Dapatkan tiket konser BABYMONSTER, aespa, NewJeans, IU, dan idol papan atas lainnya secara aman, bergaransi 100% tiket asli dengan sistem tiket elektronik instan.
                    </p>
                    <div class="d-flex gap-3 text-secondary mt-3">
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-2 rounded-pill">
                            <i class="bi bi-patch-check-fill text-success me-1"></i> Partner Resmi Promotor
                        </span>
                        <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-2 rounded-pill">
                            <i class="bi bi-shield-check text-primary me-1"></i> Transaksi Aman 256-bit
                        </span>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Idol Lineup</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}?artist=BABYMONSTER" class="footer-link">BABYMONSTER</a></li>
                        <li><a href="{{ route('home') }}?artist=aespa" class="footer-link">aespa</a></li>
                        <li><a href="{{ route('home') }}?artist=NewJeans" class="footer-link">NewJeans</a></li>
                        <li><a href="{{ route('home') }}?artist=IU" class="footer-link">IU (Lee Ji-eun)</a></li>
                        <li><a href="{{ route('home') }}" class="footer-link">Semua Konser</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Bantuan & Layanan</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('booking.check') }}" class="footer-link">Cek Status Pemesanan</a></li>
                        <li><a href="{{ route('home') }}#panduan" class="footer-link">Tata Cara Penukaran Tiket</a></li>
                        <li><a href="#" class="footer-link">Syarat & Ketentuan Konser</a></li>
                        <li><a href="#" class="footer-link">Kebijakan Privasi</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="footer-link text-warning"><i class="bi bi-lock me-1"></i>Admin Dashboard</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Metode Pembayaran</h5>
                    <p class="small text-secondary mb-2">Mendukung pembayaran instan & verifikasi otomatis:</p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-white text-dark px-2 py-1 fw-bold border">QRIS</span>
                        <span class="badge bg-white text-dark px-2 py-1 fw-bold border">BCA VA</span>
                        <span class="badge bg-white text-dark px-2 py-1 fw-bold border">Mandiri VA</span>
                        <span class="badge bg-white text-dark px-2 py-1 fw-bold border">BRI VA</span>
                        <span class="badge bg-white text-dark px-2 py-1 fw-bold border">GoPay</span>
                        <span class="badge bg-white text-dark px-2 py-1 fw-bold border">OVO</span>
                    </div>
                    <div class="mt-3 text-secondary small">
                        <i class="bi bi-clock-history me-1"></i> Layanan CS: 24/7 Siaga War Tiket
                    </div>
                </div>
            </div>

            <hr class="border-secondary opacity-25 my-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-secondary small">
                <div>
                    &copy; 2026 TiketIdol.com — Sistem Pemesanan Tiket Konser Idol. Terinspirasi oleh antarmuka modern tiket.com.
                </div>
                <div class="mt-2 mt-md-0">
                    <span class="text-white fw-semibold">Made with Laravel 12 & MySQL</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
