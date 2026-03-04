<footer>
    <div class="footerWrapper footerStyleOne">

        {{-- ── Main footer columns ── --}}
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="row gy-4">

                    {{-- Brand + Contact --}}
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-brand">
                            @if (get_setting('site_dark_logo'))
                                <img src="{{ asset(getFilePath(get_setting('site_dark_logo'))) }}"
                                    alt="{{ get_setting('site_name') }}" class="mb-3" style="max-height: 50px;">
                            @else
                                <h3 class="footer-site-name mb-3">{{ get_setting('site_name') }}</h3>
                            @endif

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
                                            <a href="{{ get_setting($key) }}" class="footer-social-btn" target="_blank"
                                                rel="noopener noreferrer">
                                                <i class="{{ $icon }}"></i>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Footer Menu — each parent with children = its own column --}}
                    @if ($footer_menu_items->isNotEmpty())
                        @php
                            $grouped_items = $footer_menu_items->filter(fn($i) => $i->children->isNotEmpty());
                            $flat_items = $footer_menu_items->filter(fn($i) => $i->children->isEmpty());
                        @endphp

                        @foreach ($grouped_items as $item)
                            <div class="col-lg-2 col-md-3 col-6">
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
                            </div>
                        @endforeach

                        @if ($flat_items->isNotEmpty())
                            <div class="col-lg-2 col-md-3 col-6">
                                <ul class="footer-links">
                                    @foreach ($flat_items as $item)
                                        <li>
                                            <a href="{{ $item->link() }}"
                                                @if ($item->target) target="_blank" rel="noopener noreferrer" @endif>
                                                {{ $item->translation('title') }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>

        {{-- ── Newsletter Subscribe ── --}}
        <div class="footer-newsletter-area">
            <div class="container">
                <div class="footer-border py-4">
                    <div class="row align-items-center">
                        <div class="col-lg-5 mb-3 mb-lg-0">
                            <h5 class="footer-newsletter-title mb-1">Subscribe to our Newsletter</h5>
                            <p class="footer-newsletter-desc mb-0 text-muted" style="font-size:14px;">
                                Get the latest listings and updates delivered to your inbox.
                            </p>
                        </div>
                        <div class="col-lg-7">
                            <form id="footer-newsletter-form" class="d-flex gap-2">
                                @csrf
                                <input type="email" name="email" id="newsletter-email"
                                    class="form-control" placeholder="Enter your email address" required
                                    style="border-radius:4px;">
                                <button type="submit" class="btn btn-primary px-4" style="white-space:nowrap;">
                                    Subscribe
                                </button>
                            </form>
                            <div id="newsletter-msg" class="mt-2" style="display:none;font-size:13px;"></div>
                        </div>
                    </div>
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

<script>
(function ($) {
    'use strict';
    $('#footer-newsletter-form').on('submit', function (e) {
        e.preventDefault();
        var $btn = $(this).find('button[type=submit]');
        var $msg = $('#newsletter-msg');
        $btn.prop('disabled', true).text('Subscribing...');
        $msg.hide();
        $.ajax({
            url: '{{ route('newsletter.subscribe') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                email: $('#newsletter-email').val(),
            },
            success: function (res) {
                if (res.success) {
                    $msg.removeClass('text-danger').addClass('text-success')
                        .text(res.message).show();
                    $('#newsletter-email').val('');
                } else {
                    $msg.removeClass('text-success').addClass('text-danger')
                        .text(res.message || 'Something went wrong.').show();
                }
            },
            error: function (xhr) {
                var msg = 'Something went wrong. Please try again.';
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = Object.values(xhr.responseJSON.errors)[0][0];
                }
                $msg.removeClass('text-success').addClass('text-danger').text(msg).show();
            },
            complete: function () {
                $btn.prop('disabled', false).text('Subscribe');
            }
        });
    });
}(jQuery));
</script>
