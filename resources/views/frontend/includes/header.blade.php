<header class="header-style-01">
    <nav class="navbar navbar-area headerBg4 navbar-expand-lg">
        <div class="container nav-container">
            <div class="responsive-mobile-menu">
                <div class="logo-wrapper">
                    <a href="{{ url('/') }}" class="logo">
                        <h3> {{ get_setting('site_name') }}</h3>
                    </a>
                </div>
                <div class="click-mobile-menu">
                    <a href="javascript:void(0)" class="click_show_icon"><i class="las la-ellipsis-v"></i> </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#bizcoxx_main_menu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
            <div class="NavWrapper">
                <!-- Main Menu -->
                <div class="collapse navbar-collapse" id="bizcoxx_main_menu">
                    <ul class="navbar-nav">
                        @foreach ($menu_items as $item)
                            @if ($item->children->isNotEmpty())
                                <li class="menu-item-has-children">
                                    <a href="{{ $item->link() }}" class="menuArrow"
                                        @if ($item->target) target="_blank" @endif>
                                        {{ $item->translation('title') }}
                                    </a>
                                    <ul class="sub-menu">
                                        @foreach ($item->children as $child)
                                            <li>
                                                <a href="{{ $child->link() }}"
                                                    @if ($child->target) target="_blank" @endif>
                                                    {{ $child->translation('title') }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $item->link() }}"
                                        @if ($item->target) target="_blank" @endif>
                                        {{ $item->translation('title') }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- Menu Right -->
            <div class="nav-right-content">
                <ul class="header-cart">

                    @if (auth()->user() == null)
                        <li>
                            <div class="btn-wrapper">
                                <a href="{{ route('member.login') }}" class="cmn-btn sign-in">
                                    Sign In
                                </a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="user-trigger dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="las la-user-circle user-icon"></i>
                                <span class="user-name">{{ Str::limit(auth()->user()->name, 12, '...') }}</span>
                                <i class="las la-angle-down caret-icon"></i>
                            </a>
                            <ul class="dropdown-menu user-dropdown dropdown-menu-end">
                                <li>
                                    <span class="dropdown-header">My Account</span>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('member.dashboard') }}">
                                        <i class="las la-tachometer-alt"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item logout-item" href="{{ route('member.logout') }}">
                                        <i class="las la-sign-out-alt"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <li class="single">
                        <div class="btn-wrapper">
                            <a href="{{ route('ad.post.page') }}" class="cmn-btn1 popup-modal">
                                <i class="las la-plus-circle"></i><span class="text">Post your ad</span>
                            </a>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>
