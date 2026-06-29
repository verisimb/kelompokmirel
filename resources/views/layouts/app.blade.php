<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SPK E-Wallet - @yield('title', 'Dashboard')</title>

    <!-- ===== FAVICON PNG ===== -->
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- Vite Asset -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Font Poppins + Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8fafc;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 270px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #ffffff;
            border-right: 1px solid #eef2f6;
            padding: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            overflow-y: auto;
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.03);
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .sidebar .brand {
            padding: 24px 20px 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            margin-bottom: 12px;
        }

        .sidebar .brand .brand-icon {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar .brand .logo-circle {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #4F46E5, #6366F1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(79, 70, 229, 0.25);
            flex-shrink: 0;
            overflow: hidden;
        }

        /* GAMBAR LOGO DI DALAM LINGKARAN UNGU */
        .sidebar .brand .logo-circle img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            border-radius: 6px;
        }

        .sidebar .brand .brand-text {
            color: #1e293b;
            font-weight: 800;
            font-size: 20px;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .sidebar .brand .brand-text span {
            color: #4F46E5;
        }

        .sidebar .brand .brand-sub {
            color: #94a3b8;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .sidebar .nav {
            padding: 0 14px 20px 14px;
        }

        .sidebar .nav-label {
            color: #94a3b8;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            padding: 16px 12px 8px 12px;
        }

        .sidebar .nav-link {
            color: #475569;
            padding: 11px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.25s ease;
            border-radius: 12px;
            margin: 2px 0;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            position: relative;
        }

        .sidebar .nav-link i {
            font-size: 20px;
            width: 26px;
            text-align: center;
            color: #94a3b8;
            transition: all 0.25s ease;
            flex-shrink: 0;
        }

        .sidebar .nav-link:hover {
            background: #f1f5f9;
            color: #1e293b;
            transform: translateX(3px);
        }

        .sidebar .nav-link:hover i {
            color: #4F46E5;
        }

        .sidebar .nav-link.active {
            background: #EEF2FF;
            color: #4F46E5;
            font-weight: 600;
            box-shadow: inset 3px 0 0 #4F46E5;
        }

        .sidebar .nav-link.active i {
            color: #4F46E5;
        }

        .sidebar .nav-link .badge-nav {
            background: #4F46E5;
            color: white;
            font-size: 9px;
            padding: 2px 10px;
            border-radius: 50px;
            margin-left: auto;
            font-weight: 600;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 270px;
            padding: 24px 32px 24px 32px;
            min-height: 100vh;
        }

        /* ===== NAVBAR TOP ===== */
        .navbar-top {
            background: #ffffff;
            padding: 16px 28px;
            border-radius: 16px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #f1f5f9;
        }

        .navbar-top .page-title {
            font-weight: 700;
            font-size: 20px;
            color: #1e293b;
            letter-spacing: -0.2px;
        }

        .navbar-top .page-title .highlight {
            background: linear-gradient(135deg, #4F46E5, #6366F1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .navbar-top .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-top .user-info .user-detail {
            text-align: right;
        }

        .navbar-top .user-info .user-detail .name {
            font-weight: 600;
            font-size: 14px;
            color: #1e293b;
        }

        .navbar-top .user-info .user-detail .role {
            font-size: 12px;
            color: #94a3b8;
        }

        .navbar-top .user-info .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #EEF2FF;
            color: #4F46E5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }

        .navbar-top .user-info .btn-logout {
            border-radius: 10px;
            padding: 6px 12px;
            font-size: 13px;
            color: #EF4444;
            border: 1px solid #EF4444;
            background: transparent;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .navbar-top .user-info .btn-logout:hover {
            background: #EF4444;
            color: white;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-left: 270px;
            padding: 18px 32px;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
            border-top: 1px solid #f1f5f9;
            background: transparent;
            margin-top: 20px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .sidebar {
                width: 76px;
                padding: 0;
            }

            .sidebar .brand .brand-text,
            .sidebar .brand .brand-sub,
            .sidebar .nav-link span,
            .sidebar .nav-label,
            .sidebar .nav-link .badge-nav {
                display: none;
            }

            .sidebar .brand .brand-icon .logo-circle {
                width: 38px;
                height: 38px;
                margin: 0 auto;
            }

            .sidebar .brand .logo-circle img {
                width: 24px;
                height: 24px;
            }

            .sidebar .brand {
                padding: 16px;
            }

            .sidebar .nav {
                padding: 0 8px;
            }

            .sidebar .nav-link {
                justify-content: center;
                padding: 12px;
                margin: 2px 0;
            }

            .sidebar .nav-link i {
                font-size: 22px;
                margin: 0;
                width: auto;
            }

            .main-content {
                margin-left: 76px;
                padding: 16px;
            }

            .footer {
                margin-left: 76px;
                padding: 16px;
            }

            .navbar-top .page-title {
                font-size: 17px;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 12px;
            }

            .navbar-top {
                padding: 12px 16px;
                flex-direction: column;
                gap: 10px;
            }

            .navbar-top .page-title {
                font-size: 15px;
            }

            .navbar-top .user-info .user-detail {
                display: none;
            }
        }

        /* ===== ANIMATIONS ===== */
        .fade-in {
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-delay-1 {
            animation-delay: 0.08s;
        }
        .fade-in-delay-2 {
            animation-delay: 0.16s;
        }
        .fade-in-delay-3 {
            animation-delay: 0.24s;
        }
        .fade-in-delay-4 {
            animation-delay: 0.32s;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06) !important;
        }
    </style>
</head>
<body>

    <!-- ===== SIDEBAR ===== -->
    <nav class="sidebar">
        <div class="brand">
            <div class="brand-icon">
                <!-- LOGO PNG DI DALAM LINGKARAN UNGU -->
                <div class="logo-circle">
                    <img src="{{ asset('images/logo.png') }}" alt="SPK E-Wallet">
                </div>
                <div>
                    <div class="brand-text"><span>E-Wallet</span></div>
                    <div class="brand-sub">Sistem Pendukung Keputusan</div>
                </div>
            </div>
        </div>

        <div class="nav">
            <div class="nav-label">Menu Utama</div>

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('kriteria.index') }}" class="nav-link {{ request()->routeIs('kriteria*') ? 'active' : '' }}">
                <i class="bi bi-list-check"></i>
                <span>Kriteria</span>
            </a>

            <a href="{{ route('alternatif.index') }}" class="nav-link {{ request()->routeIs('alternatif*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Alternatif</span>
            </a>

            <a href="{{ route('penilaian.index') }}" class="nav-link {{ request()->routeIs('penilaian*') ? 'active' : '' }}">
                <i class="bi bi-pencil-square"></i>
                <span>Penilaian</span>
            </a>

            <div class="nav-label">Perhitungan</div>

            <a href="{{ route('smart.index') }}" class="nav-link {{ request()->routeIs('smart*') ? 'active' : '' }}">
                <i class="bi bi-calculator-fill"></i>
                <span>Perhitungan SMART</span>
            </a>

            <a href="{{ route('ranking.index') }}" class="nav-link {{ request()->routeIs('ranking*') ? 'active' : '' }}">
                <i class="bi bi-trophy-fill"></i>
                <span>Ranking</span>
            </a>
        </div>
    </nav>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-content">

        <!-- ===== NAVBAR TOP ===== -->
        <div class="navbar-top">
            <div class="page-title">
                <span class="highlight">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="user-info">
                <div class="user-detail">
                    <div class="name">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <div class="role">Administrator</div>
                </div>
                <div class="avatar">
                    <i class="bi bi-person-fill"></i>
                </div>
                <a href="{{ route('logout') }}" class="btn-logout" onclick="return confirm('Yakin ingin logout?')">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>

        <!-- ===== CONTENT AREA ===== -->
        @yield('content')

    </div>

    <!-- ===== FOOTER ===== -->
    <div class="footer">
        &copy; {{ date('Y') }} SPK E-Wallet — Sistem Pendukung Keputusan Pemilihan E-Wallet Terbaik dengan Metode SMART
    </div>

    @stack('scripts')
</body>
</html>