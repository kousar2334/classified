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

                            @if (get_setting('footer_address') || get_setting('footer_phone_number') || get_setting('footer_hotline'))
                                <ul class="footer-contact-list">
                                    @if (get_setting('footer_address'))
                                        <li>
                                            <i class="las la-map-marker"></i>
                                            {{ get_setting('footer_address') }}
                                        </li>
                                    @endif
                                    @if (get_setting('footer_address_2'))
                                        <li>
                                            <i class="las la-map-marker-alt"></i>
                                            {{ get_setting('footer_address_2') }}
                                        </li>
                                    @endif
                                    @if (get_setting('footer_phone_number'))
                                        <li>
                                            <i class="las la-phone-square"></i>
                                            {{ get_setting('footer_phone_number') }}
                                        </li>
                                    @endif
                                    @if (get_setting('footer_hotline'))
                                        <li>
                                            <i class="las la-headset"></i>
                                            {{ get_setting('footer_hotline') }}
                                        </li>
                                    @endif
                                </ul>
                            @endif

                            {{-- Social Links --}}
                            @php
                                $socials = [
                                    'site_fb_link' => 'lab la-facebook-f',
                                    'site_linkedin_link' => 'lab la-linkedin-in',
                                    'site_youtube_link' => 'lab la-youtube',
                                    'site_instagram_link' => 'lab la-instagram',
                                ];
                                $hasSocial = collect($socials)->keys()->contains(fn($k) => (bool) get_setting($k));
                            @endphp
                            @if ($hasSocial)
                                <div class="footer-social-links mt-3">
                                    @foreach ($socials as $key => $icon)
                                        @if (get_setting($key))
                                            <a href="{{ get_setting($key) }}" target="_blank" rel="noopener noreferrer">
                                                <i class="{{ $icon }}"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Footer Menu --}}
                    @if ($footer_menu_items->isNotEmpty())
                        <div class="col-lg-4 col-md-3 col-6">
                            <ul class="footer-links">
                                @foreach ($footer_menu_items as $item)
                                    @if ($item->children->isNotEmpty())
                                        <li class="footer-menu-group">
                                            <h6 class="footerTittle">{{ $item->translation('title') }}</h6>
                                            <ul class="footer-links">
                                                @foreach ($item->children as $child)
                                                    <li>
                                                        <a href="{{ $child->link() }}"
                                                            @if ($child->target) target="_blank" rel="noopener noreferrer" @endif>
                                                            {{ $child->translation('title') }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $item->link() }}"
                                                @if ($item->target) target="_blank" rel="noopener noreferrer" @endif>
                                                {{ $item->translation('title') }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ── Copyright bar ── --}}
        <div class="footer-bottom-area">
            <div class="container">
                <div class="footer-border">
                    <div class="footer-copy-right text-center">
                        @if (get_setting('site_copy_right_text'))
                            <p class="pera">{!! get_setting('site_copy_right_text') !!}</p>
                        @else
                            <p class="pera">
                                All copyright &copy; {{ date('Y') }} {{ get_setting('site_name') }}. All Rights
                                Reserved.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</footer>
