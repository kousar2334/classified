<aside class="dashboard-sidebar" id="dashboardSidebar">

    {{-- Mobile close button --}}
    <button class="sidebar-close-btn" onclick="toggleSidebar()">
        <i class="fa-solid fa-xmark"></i>
    </button>

    {{-- User profile block --}}
    <div class="sidebar-user">
        @if (auth()->user()->image)
            <img src="{{ asset(getFilePath(auth()->user()->image)) }}" alt="{{ auth()->user()->name }}"
                class="sidebar-user-img">
        @else
            <div class="sidebar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        @endif
        <div>
            <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-user-role">{{ translation('Member') }}</div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav>
        <ul class="sidebar-menu">
            <li class="mt-2">
                <a href="{{ route('member.dashboard') }}"
                    class="{{ Request::routeIs('member.dashboard') ? 'active' : '' }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-gauge-high"></i></span>
                    {{ translation('Dashboard') }}
                </a>
            </li>
            <li>
                <a href="{{ route('member.my.listings') }}"
                    class="{{ Request::routeIs('member.my.listings') ? 'active' : '' }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-list-ul"></i></span>
                    {{ translation('My Ads') }}
                </a>
            </li>
            <li>
                <a href="{{ route('member.favourites') }}"
                    class="{{ Request::routeIs('member.favourites') ? 'active' : '' }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-heart"></i></span>
                    {{ translation('Favorites') }}
                </a>
            </li>
            <li>
                <a href="{{ route('member.messages.index') }}"
                    class="{{ Request::routeIs(['member.messages.index', 'member.messages.show']) ? 'active' : '' }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-comments"></i></span>
                    {{ translation('Messages') }}
                </a>
            </li>
            <li>
                <a href="{{ route('member.subscriptions') }}"
                    class="{{ Request::routeIs('member.subscriptions') ? 'active' : '' }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-crown"></i></span>
                    {{ translation('Subscriptions') }}
                </a>
            </li>
            <li>
                <a href="{{ route('member.account') }}"
                    class="{{ Request::routeIs('member.account') ? 'active' : '' }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-user"></i></span>
                    {{ translation('Account') }}
                </a>
            </li>
        </ul>

        <hr class="sidebar-divider">

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('member.logout') }}">
                    <span class="sidebar-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                    {{ translation('Logout') }}
                </a>
            </li>
        </ul>
    </nav>
</aside>
