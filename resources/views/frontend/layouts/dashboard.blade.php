@extends('frontend.layouts.master')
@section('meta')
    @yield('dash-meta')
    <style>
        :root {
            --heading-font: 'Inter', sans-serif;
            --body-font: 'Inter', sans-serif;
            --primary: #3592fc;
            --primary-dark: #524eb7;
            --sidebar-width: 240px;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --bg-light: #f9fafb;
        }

        /* Layout */
        .dashboard-container {
            display: flex;
            min-height: calc(100vh - 80px);
        }

        /* Sidebar */
        .dashboard-sidebar {
            width: var(--sidebar-width);
            background: #fff;
            border-right: 1px solid var(--border);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1rem 0;
            flex: 1;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 1.25rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 6px;
            margin: 0 0.5rem 0.15rem;
            transition: background 0.2s, color 0.2s;
        }

        .sidebar-menu li a:hover {
            background: var(--bg-light);
            color: var(--text-dark);
        }

        .sidebar-menu li a.active {
            background: rgba(53, 146, 252, 0.1);
            color: var(--primary);
            font-weight: 600;
        }

        .sidebar-menu li a i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 0.5rem 1rem;
        }

        /* Main */
        .dashboard-main {
            flex: 1;
            padding: 2rem;
            background: var(--bg-light);
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
            font-size: 0.9rem;
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

        /* Stat cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
            font-size: 0.8rem;
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

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .stat-icon.blue {
            background: rgba(53, 146, 252, 0.1);
            color: var(--primary);
        }

        .stat-icon.purple {
            background: rgba(82, 78, 183, 0.1);
            color: var(--primary-dark);
        }

        .stat-icon.green {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .stat-icon.cyan {
            background: rgba(0, 202, 213, 0.1);
            color: #00cad5;
        }

        .stat-change {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.2rem;
        }

        .stat-change.positive {
            color: #10b981;
        }

        .stat-change.negative {
            color: #ef4444;
        }

        /* Cards */
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
            margin-bottom: 1.25rem;
            padding-bottom: 0.875rem;
            border-bottom: 1px solid var(--border);
        }

        .card-title {
            font-size: 1rem;
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

        /* Activity */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .activity-item {
            display: flex;
            gap: 0.875rem;
            padding: 0.75rem;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .activity-item:hover {
            background: var(--bg-light);
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
        }

        .activity-content h4 {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.2rem;
        }

        .activity-content p {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .activity-time {
            font-size: 0.7rem;
            color: #9ca3af;
            margin-top: 0.2rem;
        }

        /* Action buttons */
        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .action-btn {
            display: block;
            padding: 0.75rem 1rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: opacity 0.2s;
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

        /* Buttons */
        .cmn-btn,
        .cmn-btn1 {
            padding: 0.6rem 1.25rem;
            border-radius: 7px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s;
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

        /* Responsive */
        @media (max-width: 1024px) {
            .dashboard-sidebar {
                position: fixed;
                left: -260px;
                top: 0;
                bottom: 0;
                z-index: 1000;
                transition: left 0.3s;
                overflow-y: auto;
                box-shadow: 2px 0 12px rgba(0, 0, 0, 0.08);
            }

            .dashboard-sidebar.active {
                left: 0;
            }

            .mobile-menu-toggle {
                display: inline-flex;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .dashboard-main {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="mobile-sidebar-overlay" onclick="toggleSidebar()"></div>
    <div class="dashboard-container">
        @include('frontend.includes.navbar')

        <main class="dashboard-main">
            <button class="mobile-menu-toggle" onclick="toggleSidebar()">
                ☰ Menu
            </button>

            @yield('dashboard-content')
        </main>
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
