<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        @if (get_setting('site_dark_logo') != null)
            <img src="{{ asset(getFilePath(get_setting('site_dark_logo'))) }}" alt="{{ get_setting('site_name') }}"
                class="brand-image" style="opacity: .8">
        @else
            <span class="brand-text font-weight-light">{{ get_setting('site_name') }}</span>
        @endif
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset(getFilePath(auth()->user()->image)) }}" class="img-circle elevation-2"
                    alt="{{ auth()->user()->name }}">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @can('View Dashboard')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ Request::routeIs(['admin.dashboard']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                {{ translation('Dashboard') }}
                            </p>
                        </a>
                    </li>
                @endcan

                <!--Members Module-->
                <li class="nav-item">
                    <a href="{{ route('admin.members.list') }}"
                        class="nav-link {{ Request::routeIs(['admin.members.list']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            {{ translation('Members') }}
                        </p>
                    </a>
                </li>

                <!--Pricing Plans Module-->
                <li class="nav-item">
                    <a href="{{ route('admin.pricing.plans.list') }}"
                        class="nav-link {{ Request::routeIs(['admin.pricing.plans.list']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            {{ translation('Pricing Plans') }}
                        </p>
                    </a>
                </li>

                <!--Listings Module-->
                <li
                    class="nav-item {{ Request::routeIs(['classified.ads.list.featured', 'classified.ads.list', 'classified.ads.custom.field.options', 'classified.ads.custom.field.list', 'classified.ads.tag.list', 'classified.ads.condition.list', 'classified.ads.categories.list']) ? 'menu-open ' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::routeIs(['classified.ads.list.featured', 'classified.ads.list', 'classified.ads.custom.field.options', 'classified.ads.custom.field.list', 'classified.ads.tag.list', 'classified.ads.condition.list', 'classified.ads.categories.list']) ? 'active ' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            {{ translation('Listings') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('classified.ads.list') }}"
                                class="nav-link {{ Request::routeIs(['classified.ads.list']) ? 'active' : '' }}">
                                <i class="fa fa-minus nav-icon"></i>
                                <p>
                                    {{ translation('All Listing') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('classified.ads.list.featured') }}"
                                class="nav-link {{ Request::routeIs(['classified.ads.list.featured']) ? 'active' : '' }}">
                                <i class="fa fa-minus nav-icon"></i>
                                <p>
                                    {{ translation('Featured Listing') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('classified.ads.categories.list') }}"
                                class="nav-link {{ Request::routeIs(['classified.ads.categories.list']) ? 'active' : '' }}">
                                <i class="fa fa-minus nav-icon"></i>
                                <p>
                                    {{ translation('Categories') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('classified.ads.custom.field.list') }}"
                                class="nav-link {{ Request::routeIs(['classified.ads.custom.field.list']) ? 'active' : '' }}">
                                <i class="fa fa-minus nav-icon"></i>
                                <p>
                                    {{ translation('Custom Fields') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('classified.ads.condition.list') }}"
                                class="nav-link {{ Request::routeIs(['classified.ads.condition.list']) ? 'active' : '' }}">
                                <i class="fa fa-minus nav-icon"></i>
                                <p>
                                    {{ translation('Conditions') }}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('classified.ads.tag.list') }}"
                                class="nav-link {{ Request::routeIs(['classified.ads.tag.list']) ? 'active' : '' }}">
                                <i class="fa fa-minus nav-icon"></i>
                                <p>
                                    {{ translation('Tags') }}
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!--Locations Module-->
                <li
                    class="nav-item {{ Request::routeIs(['classified.locations.country.list', 'classified.locations.state.list', 'classified.locations.city.list']) ? 'menu-open ' : '' }}">
                    <a href="#"
                        class="nav-link {{ Request::routeIs(['classified.locations.country.list', 'classified.locations.state.list', 'classified.locations.city.list']) ? 'active ' : '' }}">
                        <i class="nav-icon fas fa-map-marker-alt"></i>
                        <p>
                            {{ translation('Locations') }}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('classified.locations.country.list') }}"
                                class="nav-link {{ Request::routeIs(['classified.locations.country.list']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ translation('Countries') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('classified.locations.state.list') }}"
                                class="nav-link {{ Request::routeIs(['classified.locations.state.list']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ translation('States') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('classified.locations.city.list') }}"
                                class="nav-link {{ Request::routeIs(['classified.locations.city.list']) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ translation('Cities') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!--Media Module-->
                @can('Manage Media')
                    <li class="nav-item">
                        <a href="{{ route('admin.media.list') }}"
                            class="nav-link {{ Request::routeIs(['admin.media.list']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-photo-video"></i>
                            <p>
                                {{ translation('Media') }}
                            </p>
                        </a>
                    </li>
                @endcan
                <!--End Media Module-->
                @can('Manage Blog')
                    <li
                        class="nav-item {{ Request::routeIs(['admin.blogs.categories.edit', 'admin.blogs.comment.list', 'admin.blogs.edit', 'admin.blogs.list', 'admin.blogs.create', 'admin.blogs.categories.list']) ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::routeIs(['admin.blogs.categories.edit', 'admin.blogs.comment.list', 'admin.blogs.edit', 'admin.blogs.list', 'admin.blogs.create', 'admin.blogs.categories.list']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-blog"></i>
                            <p>
                                {{ translation('Blogs') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('Create New Blog')
                                <li class="nav-item">
                                    <a href="{{ route('admin.blogs.create') }}"
                                        class="nav-link {{ Request::routeIs(['admin.blogs.create']) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ translation('Write New Blog') }}</p>
                                    </a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="{{ route('admin.blogs.list') }}"
                                    class="nav-link {{ Request::routeIs(['admin.blogs.list']) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ translation('All Blogs') }}</p>
                                </a>
                            </li>
                            @can('Manage Blog Category')
                                <li class="nav-item">
                                    <a href="{{ route('admin.blogs.categories.list') }}"
                                        class="nav-link {{ Request::routeIs(['admin.blogs.categories.edit', 'admin.blogs.categories.list']) ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ translation('Categories') }}</p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan

                <!--Pages Module-->
                @can('Manage Pages')
                    <li
                        class="nav-item {{ Request::routeIs(['admin.page.edit', 'admin.page.list', 'admin.page.create']) ? 'menu-open ' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::routeIs(['admin.page.edit', 'admin.page.list', 'admin.page.create']) ? 'active ' : '' }}">
                            <i class="nav-icon fas fa-file"></i>
                            <p>
                                {{ translation('Pages') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.page.list') }}"
                                    class="nav-link {{ Request::routeIs(['admin.page.list']) ? 'active' : '' }}">
                                    <i class="fa fa-minus nav-icon"></i>
                                    <p>
                                        {{ translation('All Page') }}
                                    </p>
                                </a>
                            </li>
                            @can('Create New Page')
                                <li class="nav-item">
                                    <a href="{{ route('admin.page.create') }}"
                                        class="nav-link {{ Request::routeIs(['admin.page.create']) ? 'active' : '' }}">
                                        <i class="fa fa-minus nav-icon"></i>
                                        <p>
                                            {{ translation('Create New Page') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                <!--End Pages Module-->

                @can('Manage Appearances')
                    <li
                        class="nav-item {{ Request::routeIs(['admin.appearance.video.add','admin.appearance.video.edit','admin.appearance.video.list','admin.appearance.team.add','admin.appearance.team.edit','admin.appearance.team.list','admin.appearance.faq.add','admin.appearance.faq.edit','admin.appearance.faq.list','admin.appearance.why.us.add','admin.appearance.why.us.edit','admin.appearance.why.us.list','admin.appearance.partner.add','admin.appearance.partner.edit','admin.appearance.partner.list','admin.appearance.product.application.add','admin.appearance.product.application.edit','admin.appearance.product.application.list','admin.appearance.slider.edit.slider.item','admin.appearance.slider.add.slider.item','admin.appearance.slider.list','admin.page.content.about','admin.page.content.contact','admin.page.content.home','admin.appearance.site.setting.banner','admin.appearance.site.setting.custom.css','admin.appearance.site.setting.page','admin.appearance.site.setting.social.account','admin.appearance.site.setting','admin.appearance.menu.builder'])? 'menu-open ': '' }}">
                        <a href="#"
                            class="nav-link {{ Request::routeIs(['admin.appearance.video.add','admin.appearance.video.edit','admin.appearance.video.list','admin.appearance.team.add','admin.appearance.team.edit','admin.appearance.team.list','admin.appearance.faq.add','admin.appearance.faq.edit','admin.appearance.faq.list','admin.appearance.why.us.add','admin.appearance.why.us.edit','admin.appearance.why.us.list','admin.appearance.partner.add','admin.appearance.partner.edit','admin.appearance.partner.list','admin.appearance.product.application.add','admin.appearance.product.application.edit','admin.appearance.product.application.list','admin.appearance.slider.edit.slider.item','admin.appearance.slider.add.slider.item','admin.appearance.slider.list','admin.page.content.about','admin.page.content.contact','admin.page.content.home','admin.appearance.site.setting.banner','admin.appearance.site.setting.custom.css','admin.appearance.site.setting.page','admin.appearance.site.setting.social.account','admin.appearance.site.setting','admin.appearance.menu.builder'])? 'active': '' }}">
                            <i class="nav-icon fas fa-desktop"></i>
                            <p>
                                {{ translation('Appearances') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('Manage Menu')
                                <li class="nav-item">
                                    <a href="{{ route('admin.appearance.menu.builder') }}"
                                        class="nav-link {{ Request::routeIs(['admin.appearance.menu.builder']) ? 'active' : '' }}">
                                        <i class="fa fa-minus nav-icon"></i>
                                        <p>
                                            {{ translation('Menus') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan


                            <li class="nav-item">
                                <a href="{{ route('admin.page.content.home', ['lang' => defaultLangCode()]) }}"
                                    class="nav-link {{ Request::routeIs(['admin.page.content.home']) ? 'active' : '' }}">
                                    <i class="fa fa-minus nav-icon"></i>
                                    <p>
                                        {{ translation('Page Settings') }}
                                    </p>
                                </a>
                            </li>
                            @can('Manage Site Settings')
                                <li class="nav-item">
                                    <a href="{{ route('admin.appearance.site.setting') }}"
                                        class="nav-link {{ Request::routeIs(['admin.appearance.site.setting']) ? 'active' : '' }}">
                                        <i class="fa fa-minus nav-icon"></i>
                                        <p>
                                            {{ translation('Site Setting') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan

                        </ul>
                    </li>
                @endcan
                <!--End Appearances Module-->


                <!--Users Module-->
                @canany(['User List', 'Role List View', 'Permission List View'])
                    <li
                        class="nav-item {{ Request::routeIs(['admin.users.list', 'admin.users.permission.list', 'admin.users.role.list']) ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ Request::routeIs(['admin.users.list', 'admin.users.permission.list', 'admin.users.role.list']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                {{ translation('Users') }}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('User List')
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.list') }}"
                                        class="nav-link {{ Request::routeIs(['admin.users.list']) ? 'active' : '' }}">
                                        <i class="fa fa-minus nav-icon"></i>
                                        <p> {{ translation('Users') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('Role List View')
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.role.list') }}"
                                        class="nav-link {{ Request::routeIs(['admin.users.role.list']) ? 'active ' : '' }}">
                                        <i class="fa fa-minus nav-icon"></i>
                                        <p>{{ translation('Roles') }}</p>
                                    </a>
                                </li>
                            @endcan
                            @can('Permission List View')
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.permission.list') }}"
                                        class="nav-link {{ Request::routeIs(['admin.users.permission.list']) ? 'active ' : '' }}">
                                        <i class="fa fa-minus nav-icon"></i>
                                        <p>{{ translation('Permissions') }}</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                <!--End Users Module-->
                @can('Manage Language')
                    <li class="nav-item">
                        <a href="{{ route('admin.system.settings.language.list') }}"
                            class="nav-link {{ Request::routeIs(['admin.system.settings.language.list', 'admin.system.settings.language.translation']) ? 'active' : '' }}">
                            <i class="nav-icon fas fa-language"></i>
                            <p>
                                {{ translation('Languages') }}
                            </p>
                        </a>
                    </li>
                @endcan
                <!--System Module-->
                @canany(['Update Environment', 'Update SMTP'])
                    <li class="nav-item">
                        <a href="{{ route('admin.system.settings.environment') }}"
                            class="nav-link {{ Request::routeIs(['admin.system.settings.environment', 'admin.system.settings.smtp']) ? 'active ' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                {{ translation('System') }}
                            </p>
                        </a>
                    </li>
                @endcanany
                <!--End System Module-->
            </ul>
        </nav>
    </div>
</aside>
