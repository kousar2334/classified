 <div class="nav flex-column nav-tabs h-100" role="tablist" aria-orientation="vertical">
     <a class="nav-link {{ Request::routeIs(['admin.appearance.site.setting']) ? 'active' : '' }}"
         href="{{ route('admin.appearance.site.setting') }}">
         {{ translation('Site Settings') }}
     </a>
     <a class="nav-link {{ Request::routeIs(['admin.appearance.site.setting.footer']) ? 'active' : '' }}"
         href="{{ route('admin.appearance.site.setting.footer') }}">
         {{ translation('Footer') }}
     </a>
     <a class="nav-link {{ Request::routeIs(['admin.appearance.site.setting.seo']) ? 'active' : '' }}"
         href="{{ route('admin.appearance.site.setting.seo') }}">
         {{ translation('Seo Settings') }}
     </a>
     <a class="nav-link {{ Request::routeIs(['admin.appearance.site.setting.colors']) ? 'active' : '' }}"
         href="{{ route('admin.appearance.site.setting.colors') }}">
         {{ translation('Colors Setup') }}
     </a>
     <a class="nav-link {{ Request::routeIs(['admin.appearance.site.setting.custom.css']) ? 'active' : '' }}"
         href="{{ route('admin.appearance.site.setting.custom.css') }}">
         {{ translation('Custom CSS') }}
     </a>
 </div>
