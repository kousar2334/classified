 <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
     <li class="nav-item">
         <a class="nav-link {{ Request::routeIs(['admin.system.settings.environment']) ? 'active ' : '' }}"
             href="{{ route('admin.system.settings.environment') }}" role="tab">{{ translation('Environment Setup') }}
         </a>
     </li>
     <li class="nav-item">
         <a class="nav-link {{ Request::routeIs(['admin.system.settings.smtp']) ? 'active ' : '' }}"
             href="{{ route('admin.system.settings.smtp') }}" role="tab">{{ translation('SMTP Setup') }}
         </a>
     </li>
     <li class="nav-item">
         <a class="nav-link {{ Request::routeIs(['admin.system.settings.social.login']) ? 'active ' : '' }}"
             href="{{ route('admin.system.settings.social.login') }}"
             role="tab">{{ translation('Social Media Login') }}
         </a>
     </li>

 </ul>
