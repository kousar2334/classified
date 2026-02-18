<aside class="dashboard-sidebar " id="dashboardSidebar">
    <button class="mobile-menu-toggle" onclick="toggleSidebar()" style="margin: 0 1rem 1rem; display: none;">
        ✕
    </button>
    <ul class="sidebar-menu bg-color-c">
        <li><a href="{{ route('member.dashboard') }}"
                class="{{ Request::routeIs(['member.dashboard']) ? 'active' : '' }}"><i>📊</i> Dashboard</a></li>
        <li><a href="{{ route('member.my.listings') }}"
                class="{{ Request::routeIs(['member.my.listings']) ? 'active' : '' }}"><i>📝</i> My Listings</a></li>
        <li><a href="{{ route('member.favourites') }}"
                class="{{ Request::routeIs('member.favourites') ? 'active' : '' }}"><i>❤️</i> Favorites</a></li>
        <li><a href="{{ route('member.messages.index') }}"
                class="{{ Request::routeIs(['member.messages.index', 'member.messages.show']) ? 'active' : '' }}"><i>💬</i>
                Messages</a></li>
        <li><a href="#"><i>📈</i> Analytics</a></li>
        <li><a href="#"><i>⚙️</i> Settings</a></li>
        <li><a href="#"><i>👤</i> Profile</a></li>
        <li><a href="{{ route('member.logout') }}"><i>🚪</i> Logout</a></li>
    </ul>
</aside>
