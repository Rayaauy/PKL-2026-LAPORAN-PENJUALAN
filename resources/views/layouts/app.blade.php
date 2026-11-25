<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UMKM Sales')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 240px;
            --topbar-height: 56px;
            --color-bg: #f7f7f8;
            --color-surface: #ffffff;
            --color-border: #e5e5e7;
            --color-text: #111112;
            --color-text-muted: #6e6e80;
            --color-primary: #16a34a;
            --color-primary-hover: #15803d;
            --color-success: #22c55e;
            --color-danger: #ef4444;
            --color-warning: #f59e0b;
            --radius: 8px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow: 0 4px 12px rgba(0,0,0,.08);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--color-bg);
            color: var(--color-text);
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--color-surface);
            border-right: 1px solid var(--color-border);
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 18px 20px 16px;
            border-bottom: 1px solid var(--color-border);
        }

        .sidebar-logo a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-mark {
            width: 28px;
            height: 28px;
            background: #16a34a;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-mark svg {
            width: 14px;
            height: 14px;
            fill: white;
        }

        .logo-text {
            font-size: 14px;
            font-weight: 600;
            color: var(--color-text);
            letter-spacing: -0.2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px 10px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 12px 10px 4px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 10px;
            border-radius: var(--radius);
            color: var(--color-text-muted);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: background 0.15s, color 0.15s;
            margin-bottom: 1px;
        }

        .sidebar-nav a:hover {
            background: var(--color-bg);
            color: var(--color-text);
        }

        .sidebar-nav a.active {
            background: #dcfce7;
            color: var(--color-primary);
        }

        .sidebar-nav a i {
            font-size: 15px;
            width: 18px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-footer {
            padding: 14px;
            border-top: 1px solid var(--color-border);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: var(--radius);
            margin-bottom: 4px;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #16a34a;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .user-info {
            flex: 1;
            min-width: 0;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--color-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 11px;
            color: var(--color-text-muted);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            padding: 7px 10px;
            background: none;
            border: none;
            border-radius: var(--radius);
            color: var(--color-text-muted);
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s, color 0.15s;
            text-align: left;
        }

        .btn-logout:hover {
            background: #fef2f2;
            color: var(--color-danger);
        }

        .btn-logout i { font-size: 15px; }

        /* Main content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            height: var(--topbar-height);
            background: var(--color-surface);
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--color-text);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Page content */
        .page-content {
            padding: 28px;
            max-width: 1280px;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            font-weight: 500;
            padding: 7px 14px;
            border-radius: var(--radius);
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            line-height: 1.4;
        }

        .btn i { font-size: 14px; }

        .btn-primary {
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .btn-primary:hover {
            background: var(--color-primary-hover);
            border-color: var(--color-primary-hover);
            color: white;
        }

        .btn-secondary {
            background: var(--color-surface);
            color: var(--color-text);
            border-color: var(--color-border);
        }

        .btn-secondary:hover {
            background: var(--color-bg);
            color: var(--color-text);
        }

        .btn-danger {
            background: var(--color-surface);
            color: var(--color-danger);
            border-color: var(--color-border);
        }

        .btn-danger:hover {
            background: #fef2f2;
            border-color: #fca5a5;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12.5px;
        }

        /* Cards */
        .card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
        }

        .card-header-clean {
            padding: 16px 20px 12px;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .card-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--color-text);
            margin: 0;
        }

        .card-body-clean {
            padding: 20px;
        }

        /* Stat cards */
        .stat-card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
        }

        .stat-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 8px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--color-text);
            letter-spacing: -0.5px;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .stat-sub {
            font-size: 12px;
            color: var(--color-text-muted);
        }

        .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            font-size: 16px;
        }

        .stat-icon.purple { background: #dcfce7; color: var(--color-primary); }
        .stat-icon.green { background: #dcfce7; color: #16a34a; }
        .stat-icon.orange { background: #fff7ed; color: #ea580c; }
        .stat-icon.blue { background: #eff6ff; color: #2563eb; }

        /* Tables */
        .table-clean {
            width: 100%;
            border-collapse: collapse;
        }

        .table-clean th {
            text-align: left;
            padding: 10px 16px;
            font-size: 11.5px;
            font-weight: 600;
            color: var(--color-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 1px solid var(--color-border);
            background: var(--color-bg);
        }

        .table-clean td {
            padding: 12px 16px;
            font-size: 13.5px;
            color: var(--color-text);
            border-bottom: 1px solid var(--color-border);
        }

        .table-clean tbody tr:last-child td {
            border-bottom: none;
        }

        .table-clean tbody tr:hover td {
            background: #fafafa;
        }

        /* Badge */
        .badge-clean {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 500;
        }

        .badge-active { background: #dcfce7; color: #15803d; }
        .badge-inactive { background: #f1f5f9; color: #64748b; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-warning { background: #fef9c3; color: #a16207; }
        .badge-danger { background: #fee2e2; color: #dc2626; }

        /* Forms */
        .form-label-clean {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--color-text);
            margin-bottom: 6px;
        }

        .form-control-clean {
            width: 100%;
            padding: 8px 12px;
            font-size: 13.5px;
            color: var(--color-text);
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            font-family: 'Inter', sans-serif;
        }

        .form-control-clean:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-control-clean.is-invalid {
            border-color: var(--color-danger);
        }

        .field-error {
            font-size: 12px;
            color: var(--color-danger);
            margin-top: 5px;
        }

        /* Alerts */
        .alert-clean {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: var(--radius);
            font-size: 13.5px;
            margin-bottom: 20px;
        }

        .alert-clean i { font-size: 16px; margin-top: 1px; flex-shrink: 0; }

        .alert-success-clean {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .alert-error-clean {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fca5a5;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            width: 52px;
            height: 52px;
            background: var(--color-bg);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 22px;
            color: var(--color-text-muted);
        }

        .empty-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--color-text);
            margin-bottom: 6px;
        }

        .empty-desc {
            font-size: 13.5px;
            color: var(--color-text-muted);
            margin-bottom: 20px;
        }

        /* Mobile toggle */
        .mobile-toggle {
            display: none;
            background: none;
            border: 1px solid var(--color-border);
            border-radius: var(--radius);
            padding: 5px 8px;
            cursor: pointer;
            color: var(--color-text);
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.25s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.4);
                z-index: 99;
            }

            .sidebar-overlay.active { display: block; }

            .main-wrapper { margin-left: 0; }

            .mobile-toggle { display: flex; }

            .page-content { padding: 14px; }

            /* Topbar */
            .topbar { padding: 0 14px; }
            .topbar-title { font-size: 13.5px; }

            /* Cards */
            .card-header-clean { padding: 12px 14px; flex-wrap: wrap; gap: 8px; }
            .card-body-clean   { padding: 14px; }

            /* Stat cards */
            .stat-card { padding: 16px; }
            .stat-value { font-size: 20px; }

            /* Tables — horizontal scroll */
            .table-clean th,
            .table-clean td { padding: 10px 12px; font-size: 13px; }

            /* Hide less important table columns on mobile */
            .hide-mobile { display: none !important; }

            /* Buttons */
            .btn { font-size: 12.5px; padding: 6px 10px; }
            .btn-sm { font-size: 11.5px; padding: 4px 8px; }

            /* Forms */
            .form-control-clean { font-size: 15px; } /* prevent iOS zoom */

            /* Empty state */
            .empty-state { padding: 40px 16px; }

            /* Row/col responsive helpers */
            .row { margin: 0 -6px; }
            .row > [class*="col-"] { padding: 0 6px; }
        }

        @media (max-width: 480px) {
            .page-content { padding: 10px; }
            .card-header-clean { padding: 10px 12px; }
            .card-body-clean   { padding: 12px; }
            .stat-value { font-size: 18px; }
            .topbar { height: 50px; }
            .topbar-title { display: none; }
        }

        @media (max-width: 900px) {
            .blog-form-grid { grid-template-columns: 1fr !important; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
                <img src="/logo-sekolah.jpg" alt="Logo" style="width:32px;height:32px;object-fit:contain;border-radius:4px;flex-shrink:0;">
                <div>
                    <span class="logo-text" style="display:block;line-height:1.2;">UMKM Sales</span>
                    <span style="font-size:9.5px;color:var(--color-text-muted);font-weight:500;line-height:1;">AS-SYAFI'IYAH 01</span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Menu Utama</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="{{ route('transactions.create') }}" class="{{ request()->routeIs('transactions.create') ? 'active' : '' }}">
                <i class="bi bi-plus-square"></i> Catat Transaksi
            </a>
            <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.index') || request()->routeIs('transactions.show') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Transaksi
            </a>

            <div class="nav-section-label">Kelola Data</div>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="bi bi-box"></i> Produk
            </a>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tag"></i> Kategori
            </a>

            <div class="nav-section-label">Analitik</div>
            <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i> Laporan
            </a>

            @if(auth()->user()->is_admin)
            <div class="nav-section-label">Administrator</div>
            <a href="{{ route('admin.blog.index') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <i class="bi bi-pencil-square"></i> Kelola Blog
            </a>
            @endif

            <div class="nav-section-label">Akun</div>
            <a href="{{ route('business.edit') }}" class="{{ request()->routeIs('business.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Profil Usaha
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Pemilik Usaha</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-left"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- Main wrapper -->
    <div class="main-wrapper">
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <span class="topbar-title">@yield('title', 'Dashboard')</span>
            </div>
            <div class="topbar-actions">
                @yield('topbar-actions')
            </div>
        </header>

        <main class="page-content">
            @if(session('success'))
                <div class="alert-clean alert-success-clean" id="flash-msg">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()"
                            style="margin-left:auto; background:none; border:none; cursor:pointer; color:inherit; font-size:16px; line-height:1;">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-clean alert-error-clean" id="flash-msg-err">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()"
                            style="margin-left:auto; background:none; border:none; cursor:pointer; color:inherit; font-size:16px; line-height:1;">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }

        // Auto-dismiss flash messages after 4 seconds
        setTimeout(function() {
            ['flash-msg','flash-msg-err'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) {
                    el.style.transition = 'opacity 0.4s';
                    el.style.opacity = '0';
                    setTimeout(function() { if (el) el.remove(); }, 400);
                }
            });
        }, 4000);
    </script>
    @stack('scripts')
</body>
</html>
