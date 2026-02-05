@extends('frontend.layouts.master')
@section('meta')
    @yield('dash-meta')
    <style>
        /* heading font */
        :root {
            --heading-font1: 'Inter', sans-serif !important;
            --heading-font: 'Inter', sans-serif !important;
            --body-font1: 'Inter', sans-serif !important;
            --body-font: 'Inter', sans-serif !important;
            --main-color-one: rgb(53, 146, 252);
            --main-color-two: rgb(82, 78, 183);
            --main-color-three: rgb(0, 202, 213);
            --heading-color: #333333;
            --light-color: rgb(0, 0, 0);
            --extra-light-color: rgb(56, 147, 106);
        }


        .cmn-btn,
        .cmn-btn1 {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .cmn-btn {
            background: transparent;
            color: var(--main-color-one);
            border: 2px solid var(--main-color-one);
        }

        .cmn-btn:hover {
            background: var(--main-color-one);
            color: #fff;
        }

        .cmn-btn1 {
            background: var(--main-color-one);
            color: #fff;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .cmn-btn1:hover {
            background: var(--main-color-two);
            transform: translateY(-2px);
        }

        /* Dashboard Container */
        .dashboard-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: calc(100vh - 80px);
            max-width: 1920px;
            margin: 0 auto;
        }

        /* Sidebar */
        .dashboard-sidebar {
            background: #fff;
            padding: 2rem 0;
            border-right: 1px solid #e5e7eb;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.875rem 2rem;
            color: #6b7280;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            position: relative;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            color: var(--main-color-one);
            background: linear-gradient(90deg, rgba(53, 146, 252, 0.1) 0%, transparent 100%);
        }

        .sidebar-menu a.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--main-color-one);
        }

        .sidebar-menu i {
            margin-right: 0.75rem;
            font-size: 1.25rem;
        }

        /* Main Dashboard Content */
        .dashboard-main {
            padding: 2rem;
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .dashboard-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--heading-color);
            margin-bottom: 0.5rem;
        }

        .dashboard-header p {
            color: #6b7280;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
        }

        .stat-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, rgba(53, 146, 252, 0.1) 0%, rgba(53, 146, 252, 0.2) 100%);
            color: var(--main-color-one);
        }

        .stat-icon.purple {
            background: linear-gradient(135deg, rgba(82, 78, 183, 0.1) 0%, rgba(82, 78, 183, 0.2) 100%);
            color: var(--main-color-two);
        }

        .stat-icon.green {
            background: linear-gradient(135deg, rgba(56, 147, 106, 0.1) 0%, rgba(56, 147, 106, 0.2) 100%);
            color: var(--extra-light-color);
        }

        .stat-icon.cyan {
            background: linear-gradient(135deg, rgba(0, 202, 213, 0.1) 0%, rgba(0, 202, 213, 0.2) 100%);
            color: var(--main-color-three);
        }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--heading-color);
            margin-bottom: 0.25rem;
        }

        .stat-change {
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .stat-change.positive {
            color: #10b981;
        }

        .stat-change.negative {
            color: #ef4444;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .dashboard-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--heading-color);
        }

        .view-all {
            color: var(--main-color-one);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        /* Recent Activity */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-radius: 8px;
            transition: background 0.3s;
        }

        .activity-item:hover {
            background: #f9fafb;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-content h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--heading-color);
            margin-bottom: 0.25rem;
        }

        .activity-content p {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .activity-time {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 0.25rem;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .action-btn {
            padding: 1rem;
            background: linear-gradient(135deg, var(--main-color-one) 0%, var(--main-color-two) 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(53, 146, 252, 0.3);
        }

        .action-btn.secondary {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #374151;
        }

        .action-btn.secondary:hover {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: var(--main-color-one);
            color: #fff;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s;
            align-items: center;
            gap: 0.5rem;
        }

        .mobile-menu-toggle:hover {
            background: var(--main-color-two);
        }

        .dashboard-sidebar .mobile-menu-toggle {
            background: #fff;
            color: var(--heading-color);
            border: 1px solid #e5e7eb;
            font-size: 1.5rem;
            padding: 0.5rem;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .mobile-sidebar-overlay.active {
            display: block;
        }

        /* Responsive Adjustments */
        @media (max-width: 1200px) {
            .container-1920 {
                padding: 0 1.5rem;
            }

            .dashboard-main {
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .navbar-nav {
                gap: 1.5rem;
            }
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .dashboard-sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
                width: 280px;
                z-index: 1000;
                transition: left 0.3s ease;
                overflow-y: auto;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }

            .dashboard-sidebar.active {
                left: 0;
            }

            .dashboard-main .mobile-menu-toggle {
                display: inline-flex;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .navbar-nav {
                gap: 1rem;
                font-size: 0.9375rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 900px) {
            .NavWrapper {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-wrap: wrap;
            }

            .nav-right-content {
                gap: 0.5rem;
            }

            .cmn-btn,
            .cmn-btn1 {
                padding: 0.625rem 1.25rem;
                font-size: 0.9375rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat-card {
                padding: 1.25rem;
            }

            .stat-value {
                font-size: 1.875rem;
            }

            .dashboard-header h1 {
                font-size: 1.5rem;
            }

            .dashboard-header {
                margin-bottom: 1.5rem;
            }

            .dashboard-main {
                padding: 1rem;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .activity-item {
                flex-direction: column;
                padding: 0.75rem;
            }

            .activity-icon {
                align-self: flex-start;
            }

            .footer-area {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .footerWrapper {
                padding: 0 1rem;
            }
        }

        @media (max-width: 480px) {
            .logo h3 {
                font-size: 1.5rem;
            }

            .nav-right-content {
                width: 100%;
            }

            .cmn-btn,
            .cmn-btn1 {
                width: 100%;
                padding: 0.625rem 1rem;
                justify-content: center;
            }

            .dashboard-header h1 {
                font-size: 1.25rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .stat-header {
                margin-bottom: 0.75rem;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1.25rem;
            }

            .dashboard-card {
                padding: 1rem;
            }

            .card-title {
                font-size: 1.125rem;
            }

            .action-btn {
                padding: 0.875rem;
                font-size: 0.9375rem;
            }

            .container-1920 {
                padding: 0 1rem;
            }

            .dashboard-main .mobile-menu-toggle {
                width: 100%;
            }
        }
    </style>
@endsection
@section('content')
    <!-- Dashboard Content -->
    <div class="mobile-sidebar-overlay" onclick="toggleSidebar()"></div>
    <div class="dashboard-container plr">
        <!-- Sidebar -->
        @include('frontend.includes.navbar')

        <!-- Main Content -->
        <main class="dashboard-main">
            <!-- Mobile Menu Button -->
            <button class="mobile-menu-toggle" onclick="toggleSidebar()" style="margin-bottom: 1rem;">
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
