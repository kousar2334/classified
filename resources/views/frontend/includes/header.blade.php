<style>
    /* ── Nav Right ── */
    .nav-right-content .header-cart {
        display: flex;
        align-items: center;
        gap: 12px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    /* ── User avatar trigger ── */
    .nav-right-content .user-trigger {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 4px 6px;
        border: none;
        background: transparent;
        color: #000;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.35);
        transition: opacity 0.18s ease, transform 0.18s ease;
    }

    .nav-right-content .user-trigger:hover,
    .nav-right-content .user-trigger.show {
        opacity: 0.85;
        transform: translateY(-1px);
        background: transparent;
        color: #000;
    }

    .nav-right-content .user-trigger .user-icon {
        font-size: 30px;
        line-height: 1;
        flex-shrink: 0;
        color: #000;
    }

    .nav-right-content .user-trigger.dropdown-toggle::after {
        display: none;
    }

    .nav-right-content .user-trigger .user-name {
        max-width: 110px;
    }

    .nav-right-content .user-trigger .caret-icon {
        font-size: 12px;
        opacity: 0.8;
        transition: transform 0.2s ease;
    }

    .nav-right-content .user-trigger.show .caret-icon {
        transform: rotate(180deg);
    }

    /* ── Dropdown menu ── */
    .nav-right-content .user-dropdown {
        min-width: 190px;
        padding: 8px 0;
        border: none;
        border-radius: 14px;
        box-shadow: 0 10px 36px rgba(0, 0, 0, 0.15), 0 2px 8px rgba(0, 0, 0, 0.08);
        background: #fff;
        overflow: hidden;
        margin-top: 8px !important;
    }

    .nav-right-content .user-dropdown .dropdown-header {
        padding: 10px 16px 8px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #9ca3af;
        border-bottom: 1px solid #f3f4f6;
        margin-bottom: 4px;
    }

    .nav-right-content .user-dropdown .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 16px;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        transition: background 0.15s ease, color 0.15s ease, padding-left 0.15s ease;
    }

    .nav-right-content .user-dropdown .dropdown-item i {
        font-size: 16px;
        width: 18px;
        text-align: center;
        color: #6b7280;
        transition: color 0.15s ease;
    }

    .nav-right-content .user-dropdown .dropdown-item:hover {
        background: #f5f7ff;
        color: #4f46e5;
        padding-left: 20px;
    }

    .nav-right-content .user-dropdown .dropdown-item:hover i {
        color: #4f46e5;
    }

    .nav-right-content .user-dropdown .dropdown-divider {
        margin: 4px 0;
        border-color: #f3f4f6;
    }

    .nav-right-content .user-dropdown .dropdown-item.logout-item:hover {
        background: #fff5f5;
        color: #ef4444;
    }

    .nav-right-content .user-dropdown .dropdown-item.logout-item:hover i {
        color: #ef4444;
    }

    /* ── Responsive ── */
    @media (max-width: 991.98px) {
        .navbar-area .click_show_icon {
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }

        .navbar-area .nav-container .responsive-mobile-menu {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-area .nav-container .responsive-mobile-menu .click-mobile-menu {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-area .nav-container .responsive-mobile-menu .navbar-toggler {
            position: static;
            -webkit-transform: none;
            transform: none;
        }

        .navbar-area .nav-container .responsive-mobile-menu .click_show_icon {
            position: static;
            -webkit-transform: none;
            transform: none;
        }

        .navbar-area .nav-container .nav-right-content {
            width: 100%;
        }

        .nav-right-content .header-cart {
            flex-wrap: wrap;
            width: 100%;
            gap: 8px;
        }

        .nav-right-content .user-trigger {
            font-size: 13px;
            padding: 4px;
        }

        .nav-right-content .user-trigger .user-icon {
            font-size: 26px;
        }

        .nav-right-content .user-dropdown {
            position: absolute !important;
        }
    }
</style>
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
