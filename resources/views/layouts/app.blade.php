<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Kasir DB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 25px;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: white;
        }
        .main-content {
            margin-left: 250px;
            flex: 1;
            padding: 30px;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
            padding: 20px 25px;
            font-size: 18px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 10px;
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 20px;
        }
        .stat-value {
            font-size: 32px;
            font-weight: bold;
            margin: 10px 0;
        }
        .stat-label {
            opacity: 0.9;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="navbar-brand">
            <i class="bi bi-cart-check"></i> Kasir DB
        </div>
        <nav class="nav flex-column">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            
            <hr class="text-white-50">
            
            <div style="padding: 12px 25px; color: rgba(255, 255, 255, 0.6); font-size: 12px; font-weight: bold; text-transform: uppercase;">
                <i class="bi bi-box"></i> Inventaris
            </div>
            
            <a href="{{ route('inventaris.daftar-barang') }}" class="nav-link {{ request()->routeIs('inventaris.daftar-barang') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i> Daftar Barang
            </a>
            <a href="{{ route('inventaris.tambah-produk') }}" class="nav-link {{ request()->routeIs('inventaris.tambah-produk') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Tambah Produk
            </a>
            <a href="{{ route('inventaris.informasi') }}" class="nav-link {{ request()->routeIs('inventaris.informasi') ? 'active' : '' }}">
                <i class="bi bi-info-circle"></i> Informasi
            </a>
        </nav>
    </div>

    <div class="main-content">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i> Terjadi kesalahan!
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>