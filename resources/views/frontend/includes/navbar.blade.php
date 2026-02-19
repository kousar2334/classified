<aside class="dashboard-sidebar" id="dashboardSidebar">

    {{-- Mobile close button --}}
    <button class="sidebar-close-btn" onclick="toggleSidebar()">
        <i class="fa-solid fa-xmark"></i>
    </button>

    {{-- User profile block --}}
    <div class="sidebar-user">
        <div class="sidebar-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-user-role">Member</div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav style="flex: 1; overflow-y: auto; padding-bottom: 1rem;">
        <ul class="sidebar-menu">
            <li class="mt-2">
                <a href="{{ route('member.dashboard') }}"
                    class="{{ Request::routeIs('member.dashboard') ? 'active' : '' }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-gauge-high"></i></span>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('member.my.listings') }}"
                    class="{{ Request::routeIs('member.my.listings') ? 'active' : '' }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-list-ul"></i></span>
                    My Listings
                </a>
            </li>
            <li>
                <a href="{{ route('member.favourites') }}"
                    class="{{ Request::routeIs('member.favourites') ? 'active' : '' }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-heart"></i></span>
                    Favourites
                </a>
            </li>
            <li>
                <a href="{{ route('member.messages.index') }}"
                    class="{{ Request::routeIs(['member.messages.index', 'member.messages.show']) ? 'active' : '' }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-comments"></i></span>
                    Messages
                </a>
            </li>
            <li>
                <a href="#">
                    <span class="sidebar-icon"><i class="fa-solid fa-user"></i></span>
                    Account
                </a>
            </li>
        </ul>

        <hr class="sidebar-divider">

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('member.logout') }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                    Logout
                </a>
            </li>
        </ul>
    </nav>
</aside>
