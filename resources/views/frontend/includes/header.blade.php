 <style>
     .navbar-area .header-cart .dropdown-menu li {
         line-height: normal;
     }

     .navbar-area .header-cart .dropdown-menu .dropdown-item {
         padding: 8px 16px;
         font-size: 14px;
         color: #212529;
     }

     .navbar-area .header-cart .dropdown-menu .dropdown-item:hover {
         background-color: #f0f0f0;
     }

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

         .navbar-area .header-cart {
             flex-wrap: wrap;
             width: 100%;
             gap: 8px;
         }

         .navbar-area .header-cart .single {
             margin-left: 0;
         }

         .navbar-area .header-cart .single .btn-wrapper .cmn-btn1 {
             padding: 8px 14px;
             font-size: 13px;
         }

         .navbar-area .header-cart .single .btn-wrapper .cmn-btn1 i {
             font-size: 18px;
         }

         .navbar-area .header-cart .nav-item.dropdown {
             margin-left: 0;
         }

         .navbar-area .header-cart .nav-item.dropdown .cmn-btn.sign-in {
             padding: 8px 14px;
             font-size: 13px;
         }

         .navbar-area .header-cart .dropdown-menu {
             position: absolute;
         }
     }
 </style>
 <header class="header-style-01">
     <nav class="navbar navbar-area headerBg4 navbar-expand-lg plr">
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

                         <li>
                             <a href="index.html" class="menuArrow">Home</a>
                         </li>
                         <li>
                             <a href="about.html">About</a>
                         </li>
                         <li>
                             <a href="{{ route('ad.listing.page') }}">Listings</a>
                         </li>
                         <li>
                             <a href="membership.html">Membership</a>
                         </li>
                         <li class=" menu-item-has-children ">
                             <a href="index.html#" class="menuArrow">Pages</a>
                             <ul class="sub-menu">

                                 <li>
                                     <a href="blog.html">Blog</a>
                                 </li>
                                 <li>
                                     <a href="privacy-policy.html">Privacy Policy</a>
                                 </li>
                                 <li>
                                     <a href="terms-and-conditions.html">Terms and Conditions</a>
                                 </li>
                                 <li>
                                     <a href="faq.html">Faq</a>
                                 </li>
                                 <li>
                                     <a href="safety-informations.html">Safety Informations</a>
                                 </li>
                             </ul>
                         </li>
                         <li>
                             <a href="contact.html">Contact</a>
                         </li>
                     </ul>
                 </div>
             </div>
             <!-- Menu Right -->
             <div class="nav-right-content">
                 <ul class="header-cart">

                     @if (auth()->user() == null)
                         <div class="btn-wrapper">
                             <a href="{{ route('member.login') }}" class="cmn-btn sign-in">
                                 Sign In
                             </a>
                         </div>
                     @else
                         <li class="single nav-item dropdown">
                             <a class="cmn-btn sign-in dropdown-toggle" href="#" role="button"
                                 data-bs-toggle="dropdown" aria-expanded="false">
                                 {{ auth()->user()->name }}
                             </a>
                             <ul class="dropdown-menu dropdown-menu-end">
                                 <li>
                                     <a class="dropdown-item" href="{{ route('member.dashboard') }}">Dashboard</a>
                                 </li>
                                 <li>
                                     <a class="dropdown-item" href="{{ route('member.logout') }}">Logout</a>
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
