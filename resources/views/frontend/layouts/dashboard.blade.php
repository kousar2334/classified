@extends('frontend.layouts.master')
@section('meta')
    @yield('dash-meta')
    {{-- Font Awesome 6 via CDN (local font files are missing) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --primary: #3592fc;
            --primary-dark: #524eb7;
            --sidebar-w: 260px;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --bg-light: #f9fafb;
        }

        /* ── Page wrapper (centers the whole dashboard) ── */
        .dash-page-wrapper {
            max-width: 1440px;
            margin: 0 auto;
            min-height: calc(100vh - 80px);
            display: flex;
            flex-direction: column;
            width: 100%;
            padding: 0 1rem;
            box-sizing: border-box;
        }

        @media (min-width: 768px) {
            .dash-page-wrapper {
                padding: 0 1.5rem;
            }
        }

        @media (min-width: 1200px) {
            .dash-page-wrapper {
                padding: 0 2rem;
            }
        }

        /* ── Outer shell (sidebar + main side by side) ── */
        .dashboard-container {
            display: flex;
            flex: 1;
            margin-top: 2rem;
        }

        /* ══════════════ SIDEBAR ══════════════ */
        .dashboard-sidebar {
            width: var(--sidebar-w);
            background: #fff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        /* User profile block */
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.25rem;
            background: #1b3a6b;
        }

        .sidebar-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 2px solid rgba(255, 255, 255, 0.35);
        }

        .sidebar-user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .sidebar-user-role {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.65);
            margin-top: 2px;
        }

        /* Section labels */
        .sidebar-section-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #9ca3af;
            padding: 1rem 1.125rem 0.3rem;
        }

        /* Nav list */
        .sidebar-menu {
            list-style: none;
            margin-bottom: 0.25rem;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.75rem;
            color: var(--text-muted);
            background: var(--bg-light);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            transition: background 0.15s, color 0.15s;
        }

        .sidebar-menu li a:hover {
            background: #f0f5ff;
            color: var(--primary);
        }

        .sidebar-menu li a.active {
            background: #e0ecff;
            color: var(--primary);
            font-weight: 600;
        }

        /* Icon — no box, just the glyph */
        .sidebar-icon {
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
            color: var(--text-muted);
            transition: color 0.15s;
        }

        .sidebar-menu li a:hover .sidebar-icon {
            color: var(--primary);
        }

        .sidebar-menu li a.active .sidebar-icon {
            color: var(--primary);
        }

        .sidebar-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 0.5rem 1rem;
        }

        /* Mobile close button */
        .sidebar-close-btn {
            display: none;
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background: var(--bg-light);
            border: 1px solid var(--border);
            border-radius: 6px;
            width: 28px;
            height: 28px;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* ══════════════ MAIN AREA ══════════════ */
        .dashboard-main {
            flex: 1;
            padding: 2rem 2rem 1.5rem;
            padding-top: 0px !important;
            min-width: 0;
        }

        /* Mobile toggle */
        .mobile-menu-toggle {
            display: none;
            align-items: center;
            gap: 0.5rem;
            background: #fff;
            border: 1px solid var(--border);
            color: var(--text-dark);
            padding: 0.5rem 0.875rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            margin-bottom: 1.25rem;
        }

        .mobile-sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 999;
        }

        .mobile-sidebar-overlay.active {
            display: block;
        }

        /* ══════════════ STAT CARDS ══════════════ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.25rem;
            border-radius: 10px;
            border: 1px solid var(--border);
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .stat-icon.blue {
            background: rgba(53, 146, 252, 0.12);
            color: var(--primary);
        }

        .stat-icon.purple {
            background: rgba(82, 78, 183, 0.12);
            color: var(--primary-dark);
        }

        .stat-icon.green {
            background: rgba(16, 185, 129, 0.12);
            color: #10b981;
        }

        .stat-icon.cyan {
            background: rgba(0, 202, 213, 0.12);
            color: #00cad5;
        }

        .stat-change {
            font-size: 0.78rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        .stat-change.positive {
            color: #10b981;
        }

        .stat-change.negative {
            color: #ef4444;
        }

        /* ══════════════ CARDS ══════════════ */
        .dashboard-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid var(--border);
            padding: 1.25rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.1rem;
            padding-bottom: 0.875rem;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .view-all {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Activity list */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.7rem 0.75rem;
            border-radius: 8px;
            transition: background 0.15s;
        }

        .activity-item:hover {
            background: var(--bg-light);
        }

        .activity-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.85rem;
        }

        .activity-content {
            flex: 1;
            min-width: 0;
        }

        .activity-content h4 {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.15rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .activity-content p {
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .activity-time {
            font-size: 0.7rem;
            color: #9ca3af;
            margin-top: 0.15rem;
        }

        /* Quick actions */
        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.15s;
        }

        .action-btn:hover {
            opacity: 0.85;
            color: #fff;
        }

        .action-btn.secondary {
            background: var(--bg-light);
            color: var(--text-dark);
            border: 1px solid var(--border);
        }

        /* Badge */
        .badge-status {
            display: inline-block;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-status.active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .badge-status.inactive {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* Shared buttons */
        .cmn-btn,
        .cmn-btn1 {
            padding: 0.6rem 1.25rem;
            border-radius: 7px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: opacity 0.15s;
        }

        .cmn-btn {
            background: transparent;
            color: var(--primary);
            border: 1.5px solid var(--primary);
        }

        .cmn-btn:hover {
            background: var(--primary);
            color: #fff;
        }

        .cmn-btn1 {
            background: var(--primary);
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .cmn-btn1:hover {
            opacity: 0.85;
        }

        /* ══════════════ RESPONSIVE ══════════════ */

        /* Prevent horizontal scroll when sidebar drawer opens */
        body {
            overflow-x: hidden;
        }

        /* ─── Tablet / small laptop (≤ 1024px) ─── */
        @media (max-width: 1024px) {

            /* Remove side borders — layout is now full-width */
            .dashboard-container {
                border-left: none;
                border-right: none;
            }

            /* Turn sidebar into a fixed off-canvas drawer */
            .dashboard-sidebar {
                position: fixed !important;
                /* !important overrides any inline style */
                left: -280px;
                top: 0;
                bottom: 0;
                z-index: 1050;
                transition: left 0.3s ease;
                overflow-y: auto;
                box-shadow: 4px 0 24px rgba(0, 0, 0, 0.12);
            }

            .dashboard-sidebar.active {
                left: 0;
            }

            /* Show mobile controls */
            .sidebar-close-btn {
                display: flex;
            }

            .mobile-menu-toggle {
                display: inline-flex;
            }

            /* Stack content panels vertically */
            .content-grid {
                grid-template-columns: 1fr;
            }

            /* Stats go 2-col on tablet */
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            /* Tighter main padding */
            .dashboard-main {
                padding: 1.25rem 1.5rem;
            }
        }

        /* ─── Mobile landscape / large phone (≤ 768px) ─── */
        @media (max-width: 768px) {
            .dashboard-main {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            /* Full-width menu toggle */
            .mobile-menu-toggle {
                width: 100%;
                justify-content: center;
            }

            /* Card headers wrap if needed */
            .card-header {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            /* Slightly smaller stat numbers */
            .stat-value {
                font-size: 1.5rem;
            }
        }

        /* ─── Small phone (≤ 480px) ─── */
        @media (max-width: 480px) {
            .dashboard-main {
                padding: 0.75rem;
            }

            /* Single-column everything */
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.375rem;
            }

            .stat-icon {
                width: 36px;
                height: 36px;
                font-size: 0.95rem;
            }

            .dashboard-card {
                padding: 1rem;
            }

            /* Activity items — allow wrapping on very small screens */
            .activity-item {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .activity-content h4 {
                font-size: 0.8rem;
            }

            .action-btn {
                font-size: 0.8rem;
                padding: 0.6rem 0.875rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="mobile-sidebar-overlay" onclick="toggleSidebar()"></div>
    <div class="dash-page-wrapper">
        <div class="dashboard-container container">
            @include('frontend.includes.navbar')

            <main class="dashboard-main">
                <button class="mobile-menu-toggle" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i> Menu
                </button>

                @yield('dashboard-content')
            </main>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('dashboardSidebar');
            const overlay = document.querySelector('.mobile-sidebar-overlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }
    </script>
    @yield('dashboard-js')
@endsection
