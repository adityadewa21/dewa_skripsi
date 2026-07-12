<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
            font-size: 14px;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a, #1e293b);
        }

        .sidebar .brand {
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: .5px;
        }

        .sidebar a {
            color: #cbd5e1;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: .2s;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255,255,255,.1);
            color: #fff;
        }

        .sidebar .menu-title {
            font-size: 11px;
            color: #94a3b8;
            text-transform: uppercase;
            margin: 20px 0 8px;
            padding-left: 6px;
        }

        .navbar-admin {
            background-color: #fff;
            border-bottom: 1px solid #e5e7eb;
        }

        .content-wrapper {
            padding: 28px;
        }

        .card {
            border: none;
            border-radius: 14px;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #0f172a;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
    </style>

    @stack('css')
</head>
<body>

<div class="d-flex">

    {{-- SIDEBAR --}}
    <aside class="sidebar p-4">
        <div class="brand text-white mb-4">
            🛍 Admin Panel
        </div>

    <nav class="nav flex-column">

        {{-- DASHBOARD --}}
        <a href="{{ route('admin.dashboard') }}"
        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <div class="menu-title">Master Data</div>

        {{-- CATEGORY --}}
        <a href="{{ route('categories') }}"
        class="{{ request()->routeIs(
                'categories',
                'categories.*'
        ) ? 'active' : '' }}">
            <i class="bi bi-tags"></i>
            Category
        </a>

        {{-- PRODUCT --}}
        <a href="{{ route('products') }}"
        class="{{ request()->routeIs(
                'products',
                'products.*'
        ) ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            Product
        </a>

        <div class="menu-title">Transaksi</div>

        {{-- ORDER --}}
        <a href="{{ route('orders.order') }}"
        class="{{ request()->routeIs(
                'orders.order',
                'orders.*'
        ) ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>
            Order
        </a>

        {{-- CUSTOMER --}}
        <a href="{{ route('admin.customers') }}"
        class="{{ request()->routeIs(
                'admin.customers',
                'admin.customers.*'
        ) ? 'active' : '' }}">
            <i class="bi bi-people"></i>
            Customer
        </a>

        {{-- ANALYTICS --}}
        <a href="{{ route('admin.analytics') }}"
        class="{{ request()->routeIs(
                'admin.analytics',
                'admin.analytics.*'
        ) ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i>
            Analitik Produk
        </a>

        <hr class="text-secondary my-3">

        {{-- LOGOUT --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-light btn-sm w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>

    </nav>

    </aside>

    {{-- MAIN --}}
    <main class="flex-grow-1">

        {{-- TOPBAR --}}
        <nav class="navbar navbar-admin px-4 py-3">
            <div class="ms-auto d-flex align-items-center gap-2">
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <small class="text-muted">Administrator</small>
                </div>
            </div>
        </nav>

        {{-- CONTENT --}}
        <div class="content-wrapper">
            @yield('content')
        </div>

    </main>

</div>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@stack('js')

</body>
</html>
