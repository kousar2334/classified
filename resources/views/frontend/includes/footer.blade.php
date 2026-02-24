<footer>
    <div class="footerWrapper footerStyleOne">

        {{-- ── Main footer columns ── --}}
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="row gy-4">

                    {{-- Brand + Contact --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-brand">
                            <h3 class="footer-site-name">{{ get_setting('site_name') }}</h3>
                            <p class="footer-tagline">Find the best deals near you.</p>
                            <ul class="footer-contact-list">
                                <li>
                                    <i class="las la-map-marker"></i>
                                    Dhaka, Bangladesh
                                </li>
                                <li>
                                    <i class="las la-phone-square"></i>
                                    +627-521-1504
                                </li>
                                <li>
                                    <i class="las la-envelope"></i>
                                    info@example.com
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Categories --}}
                    <div class="col-lg-3 col-md-3 col-6">
                        <h6 class="footerTittle">Categories</h6>
                        <ul class="footer-links">
                            <li><a href="#">Education</a></li>
                            <li><a href="#">Appliances</a></li>
                            <li><a href="#">Pets &amp; Animals</a></li>
                            <li><a href="#">Sports</a></li>
                            <li><a href="#">Fashion</a></li>
                        </ul>
                    </div>

                    {{-- About --}}
                    <div class="col-lg-3 col-md-3 col-6">
                        <h6 class="footerTittle">About</h6>
                        <ul class="footer-links">
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Terms &amp; Conditions</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>

                    {{-- Help & Support --}}
                    <div class="col-lg-2 col-md-3 col-6">
                        <h6 class="footerTittle">Help &amp; Support</h6>
                        <ul class="footer-links">
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Safety Info</a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Copyright bar ── --}}
        <div class="footer-bottom-area">
            <div class="container">
                <div class="footer-border">
                    <div class="footer-copy-right text-center">
                        <p class="pera">
                            All copyright &copy; {{ date('Y') }} {{ get_setting('site_name') }}. All Rights
                            Reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</footer>
