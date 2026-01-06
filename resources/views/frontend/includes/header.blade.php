 <header class="header-style-01">
     <nav class="navbar navbar-area headerBg4 navbar-expand-lg plr">
         <div class="container-fluid container-1920 container-two nav-container">
             <div class="responsive-mobile-menu">
                 <div class="logo-wrapper">
                     <a href="index.html" class="logo">
                         <h3> {{ get_setting('site_name') }}</h3>
                     </a>
                 </div>
                 <div class="click-mobile-menu">
                     <a href="index.html#0" class="click_show_icon"><i class="las la-ellipsis-v"></i> </a>
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
                             <a href="listings.html">Listings</a>
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
                     <li class="single userAccount">
                         <div class="btn-wrapper">
                             <a href="user/listing/add.html" class="cmn-btn sign-in">
                                 Sign In
                             </a>
                         </div>


                     </li>
                     <li class="single">
                         <div class="btn-wrapper">
                             <a href="listing/guest/add-listing.html" class="cmn-btn1 popup-modal">
                                 <i class="las la-plus-circle"></i><span class="text">Post your ad</span>
                             </a>
                         </div>
                     </li>

                 </ul>
             </div>
         </div>
     </nav>
 </header>
