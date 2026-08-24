<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Portal — Postryx AI')</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Design System -->
    <link rel="stylesheet" href="{{ asset('css/postryx-theme.css') }}">
    
    <!-- DataTables & jQuery -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <style>
        /* Admin Layout & Sidebar Architecture */
        .admin-layout {
            display: flex;
            min-height: 100vh;
            background-color: var(--bg-main);
        }

        .admin-sidebar {
            width: 270px;
            background: rgba(11, 17, 30, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid var(--border-subtle);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            padding: 24px 16px;
            transition: all 0.3s ease;
        }

        .admin-main {
            margin-left: 270px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 100vh;
        }

        .admin-topbar {
            height: 70px;
            background: rgba(6, 9, 15, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-subtle);
            position: sticky;
            top: 0;
            z-index: 90;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
        }

        .admin-content {
            padding: 32px;
            flex: 1;
        }

        /* Sidebar Navigation Item */
        .admin-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            margin-bottom: 4px;
            border: 1px solid transparent;
        }

        .admin-nav-item:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
            transform: translateX(3px);
        }

        .admin-nav-item.active {
            color: #ffffff;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.25) 0%, rgba(6, 182, 212, 0.15) 100%);
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 0 20px -3px rgba(99, 102, 241, 0.35);
        }

        .admin-nav-item .nav-icon {
            font-size: 18px;
            width: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Cyber DataTables Custom Dark Styles */
        .dataTables_wrapper {
            color: var(--text-primary);
            font-family: inherit;
            margin-top: 16px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-secondary) !important;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .dataTables_wrapper .dataTables_filter input {
            background: var(--bg-input) !important;
            border: 1px solid var(--border-subtle) !important;
            border-radius: 8px !important;
            color: #fff !important;
            padding: 8px 12px !important;
            outline: none !important;
            margin-left: 8px !important;
        }

        .dataTables_wrapper .dataTables_length select {
            background: var(--bg-input) !important;
            border: 1px solid var(--border-subtle) !important;
            border-radius: 8px !important;
            color: #fff !important;
            padding: 6px 10px !important;
            outline: none !important;
            margin: 0 6px !important;
        }

        table.dataTable {
            width: 100% !important;
            border-collapse: collapse !important;
            background: transparent !important;
            border-bottom: 1px solid var(--border-subtle) !important;
        }

        table.dataTable thead th {
            background: rgba(15, 23, 42, 0.8) !important;
            color: var(--text-muted) !important;
            font-weight: 700 !important;
            font-size: 12px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            padding: 14px 16px !important;
            border-bottom: 1px solid var(--border-subtle) !important;
        }

        table.dataTable tbody td {
            background: transparent !important;
            color: var(--text-primary) !important;
            padding: 14px 16px !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            font-size: 13px !important;
            vertical-align: middle !important;
        }

        table.dataTable tbody tr:hover td {
            background: rgba(255, 255, 255, 0.03) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-subtle) !important;
            border-radius: 8px !important;
            color: var(--text-secondary) !important;
            padding: 5px 12px !important;
            margin: 0 3px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #6366f1, #4f46e5) !important;
            color: #fff !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.5) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            color: #fff !important;
        }

        @media (max-width: 1024px) {
            .admin-sidebar { width: 80px; padding: 16px 8px; }
            .admin-sidebar .nav-label, .admin-sidebar .brand-text { display: none; }
            .admin-main { margin-left: 80px; }
        }
    </style>
</head>
<body>

    <div class="admin-layout">
        
        {{-- Fixed Admin Sidebar --}}
        <aside class="admin-sidebar">
            
            {{-- Brand Logo --}}
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 32px; padding: 0 8px;">
                <img src="{{ asset('images/logo.png') }}" alt="Postryx Admin Logo" style="width: 38px; height: 38px; border-radius: 10px; object-fit: cover; box-shadow: 0 0 20px rgba(99, 102, 241, 0.6); border: 1px solid rgba(99, 102, 241, 0.4);">
                <div class="brand-text" style="display: flex; flex-direction: column;">
                    <span style="font-family: var(--font-display); font-size: 20px; font-weight: 900; color: #ffffff; letter-spacing: -0.03em;">POSTRYX<span style="color: #fbbf24;">.ADMIN</span></span>
                    <span style="font-size: 10px; color: #fbbf24; letter-spacing: 0.08em; text-transform: uppercase; font-weight: 700; margin-top: -3px;">Master Control Center</span>
                </div>
            </div>

            {{-- Navigation Links --}}
            <nav style="display: flex; flex-direction: column; gap: 2px; flex: 1;">
                
                <div class="nav-label" style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em; padding: 8px 12px 6px;">
                    Analytics &amp; Revenue
                </div>

                <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon">📊</span>
                    <span class="nav-label">Overview &amp; Metrics</span>
                </a>

                <a href="{{ route('admin.orders') }}" class="admin-nav-item {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <span class="nav-icon">💳</span>
                    <span class="nav-label">Orders &amp; Invoices</span>
                </a>

                <div class="nav-label" style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em; padding: 16px 12px 6px;">
                    User Base &amp; Growth
                </div>

                <a href="{{ route('admin.users') }}" class="admin-nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <span class="nav-icon">👥</span>
                    <span class="nav-label">User Accounts</span>
                </a>

                <a href="{{ route('admin.affiliates') }}" class="admin-nav-item {{ request()->routeIs('admin.affiliates') ? 'active' : '' }}">
                    <span class="nav-icon">🤝</span>
                    <span class="nav-label">Affiliate Partners (30%)</span>
                </a>

                <a href="{{ route('admin.payouts') }}" class="admin-nav-item {{ request()->routeIs('admin.payouts') ? 'active' : '' }}">
                    <span class="nav-icon">💸</span>
                    <span class="nav-label">Payout Requests</span>
                </a>

                <div class="nav-label" style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em; padding: 16px 12px 6px;">
                    Content &amp; SEO Marketing
                </div>

                <a href="{{ route('admin.blogs') }}" class="admin-nav-item {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}">
                    <span class="nav-icon">📝</span>
                    <span class="nav-label">Blog Articles (CMS)</span>
                </a>

                <div class="nav-label" style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.08em; padding: 16px 12px 6px;">
                    AI Engine &amp; System
                </div>

                <a href="{{ route('admin.generations') }}" class="admin-nav-item {{ request()->routeIs('admin.generations') ? 'active' : '' }}">
                    <span class="nav-icon">⚡</span>
                    <span class="nav-label">Generations Stream</span>
                </a>

                <a href="{{ route('admin.settings') }}" class="admin-nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <span class="nav-icon">⚙️</span>
                    <span class="nav-label">System Health &amp; Keys</span>
                </a>

            </nav>

            {{-- Bottom App Link & Profile --}}
            <div style="border-top: 1px solid var(--border-subtle); padding-top: 16px; margin-top: auto;">
                <a href="{{ route('home') }}" target="_blank" class="admin-nav-item" style="color: #38bdf8;">
                    <span class="nav-icon">🌐</span>
                    <span class="nav-label">View Live Site &rarr;</span>
                </a>
                <a href="{{ route('dashboard') }}" class="admin-nav-item">
                    <span class="nav-icon">👤</span>
                    <span class="nav-label">Member Dashboard</span>
                </a>
            </div>

        </aside>

        {{-- Main Admin View Area --}}
        <div class="admin-main">
            
            {{-- Top Header Bar --}}
            <header class="admin-topbar">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span class="badge-pill-amber" style="font-size: 11px;">👑 Super Admin Mode</span>
                    <div style="font-size: 13px; color: var(--text-muted);" id="admin-live-clock">--:--:--</div>
                </div>

                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, #fbbf24, #f59e0b); display: flex; align-items: center; justify-content: center; font-weight: 800; color: #000; font-size: 14px;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div style="display: flex; flex-direction: column;">
                            <span style="font-size: 13px; font-weight: 700; color: #fff;">{{ Auth::user()->name ?? 'Administrator' }}</span>
                            <span style="font-size: 11px; color: #fbbf24;">Master Admin</span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-secondary" style="padding: 7px 14px; font-size: 12px;">Logout</button>
                    </form>
                </div>
            </header>

            {{-- Flash Alert Container --}}
            @if(session('success'))
            <div style="margin: 24px 32px 0; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); border-radius: 12px; padding: 14px 20px; color: #6ee7b7; font-size: 14px; font-weight: 600;">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div style="margin: 24px 32px 0; background: rgba(244, 63, 94, 0.15); border: 1px solid rgba(244, 63, 94, 0.4); border-radius: 12px; padding: 14px 20px; color: #fca5a5; font-size: 14px; font-weight: 600;">
                {{ session('error') }}
            </div>
            @endif

            {{-- Content Slot --}}
            <main class="admin-content">
                @yield('content')
            </main>

        </div>

    </div>

    {{-- Master Engine JS --}}
    <script src="{{ asset('js/postryx-engine.js') }}"></script>

    <script>
        // Live Clock
        function updateClock() {
            const now = new Date();
            const el = document.getElementById('admin-live-clock');
            if (el) el.textContent = now.toLocaleTimeString() + ' (' + Intl.DateTimeFormat().resolvedOptions().timeZone + ')';
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Universal DataTable Init
        $(document).ready(function() {
            $('.postryx-datatable').DataTable({
                pageLength: 15,
                responsive: true,
                order: [[0, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Instant search records...",
                    lengthMenu: "Show _MENU_ entries"
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
