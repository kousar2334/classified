@extends('frontend.layouts.dashboard')
@section('dash-meta')
    <title>Dashboard - {{ get_setting('site_name') }}</title>
@endsection
@section('dashboard-content')
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1>Welcome back, User!</h1>
        <p>Here's what's happening with your listings today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Listings</span>
                <div class="stat-icon blue">📦</div>
            </div>
            <div class="stat-value">24</div>
            <div class="stat-change positive">
                <span>↑</span> 12% from last month
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Views</span>
                <div class="stat-icon purple">👁️</div>
            </div>
            <div class="stat-value">1,847</div>
            <div class="stat-change positive">
                <span>↑</span> 23% from last week
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Messages</span>
                <div class="stat-icon green">💬</div>
            </div>
            <div class="stat-value">32</div>
            <div class="stat-change positive">
                <span>↑</span> 8 new messages
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Favorites</span>
                <div class="stat-icon cyan">⭐</div>
            </div>
            <div class="stat-value">156</div>
            <div class="stat-change positive">
                <span>↑</span> 5% increase
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Recent Activity -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">Recent Activity</h3>
                <a href="#" class="view-all">View All →</a>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon blue">👤</div>
                    <div class="activity-content">
                        <h4>New message from John Doe</h4>
                        <p>Interested in your "Vintage Camera" listing</p>
                        <div class="activity-time">2 hours ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon green">⭐</div>
                    <div class="activity-content">
                        <h4>Your listing was favorited</h4>
                        <p>"Antique Wooden Chair" added to 3 favorites</p>
                        <div class="activity-time">5 hours ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon purple">📝</div>
                    <div class="activity-content">
                        <h4>Listing approved</h4>
                        <p>"Gaming Console Bundle" is now live</p>
                        <div class="activity-time">1 day ago</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon cyan">👁️</div>
                    <div class="activity-content">
                        <h4>High view count</h4>
                        <p>"Designer Handbag" reached 250 views</p>
                        <div class="activity-time">2 days ago</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="card-title">Quick Actions</h3>
            </div>
            <div class="quick-actions">
                <a href="#" class="action-btn">➕ Post New Ad</a>
                <a href="#" class="action-btn secondary">📊 View Analytics</a>
                <a href="#" class="action-btn secondary">💬 Check Messages</a>
                <a href="#" class="action-btn secondary">⚙️ Account Settings</a>
            </div>
        </div>
    </div>
@endsection
