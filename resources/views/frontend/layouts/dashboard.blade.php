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

        /* ── Page wrapper ── */
        .dash-page-wrapper {
            min-height: calc(100vh - 80px);
            display: flex;
            flex-direction: column;
        }

        /* ── Outer shell: Bootstrap container + flex row (sidebar + main) ── */
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

        /* ══════════════ SHARED LISTING CARD STYLES (my-listings & favourites) ══════════════ */
        .my-listings-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .my-listings-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .filters-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 250px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9375rem;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
        }

        .search-box .search-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .sort-select {
            padding: 0.75rem 2rem 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            font-size: 0.9375rem;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
        }

        .sort-select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .listings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .listing-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border);
            transition: all 0.3s;
        }

        .listing-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .listing-image {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .listing-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .listing-status {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .listing-status.active {
            background: #10b981;
            color: #fff;
        }

        .listing-status.inactive {
            background: #6b7280;
            color: #fff;
        }

        .listing-status.sold {
            background: #ef4444;
            color: #fff;
        }

        .listing-status.featured {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #fff;
        }

        .listing-actions-overlay {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            display: flex;
            gap: 0.5rem;
        }

        .listing-action-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #374151;
        }

        .listing-action-btn:hover {
            background: var(--primary);
            color: #fff;
        }

        .listing-action-btn.remove-fav:hover {
            background: #ef4444;
            color: #fff;
        }

        .listing-content {
            padding: 1rem;
        }

        .listing-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .listing-title a {
            color: inherit;
            text-decoration: none;
        }

        .listing-title a:hover {
            color: var(--primary);
        }

        .listing-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        .listing-meta svg {
            flex-shrink: 0;
        }

        .listing-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px solid #f3f4f6;
        }

        .listing-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary);
        }

        .listing-views {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        .listing-date {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 0.5rem;
        }

        .pagination-wrapper {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        .empty-listings {
            text-align: center;
            padding: 4rem 2rem;
            background: #fff;
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .empty-listings .icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-listings h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .empty-listings p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .empty-listings .cmn-btn1 {
            display: inline-flex;
        }

        /* Listing-tabs (my-listings) */
        .listing-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .listing-tab {
            padding: 0.625rem 1.25rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #fff;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .listing-tab:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .listing-tab.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        .listing-tab .count {
            background: rgba(0, 0, 0, .1);
            padding: 0.125rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
        }

        .listing-tab.active .count {
            background: rgba(255, 255, 255, .2);
        }

        /* Favourites count badge */
        .fav-count-badge {
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fecaca;
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* ── Responsive: shared listing grid ── */
        @media (max-width: 768px) {
            .my-listings-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .listing-tabs {
                width: 100%;
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 0.5rem;
            }

            .listing-tab {
                white-space: nowrap;
            }

            .filters-row {
                flex-direction: column;
            }

            .search-box {
                min-width: 100%;
            }

            .sort-select {
                width: 100%;
            }

            .listings-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="mobile-sidebar-overlay" onclick="toggleSidebar()"></div>
    <div class="dash-page-wrapper">
        <div class="dashboard-container container px-0">
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
