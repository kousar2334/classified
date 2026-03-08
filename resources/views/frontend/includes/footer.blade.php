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
                    {{-- Newsletter Column --}}
                    <div class="col-lg-3 col-md-6">
                        <h6 class="footerTittle">{{ translation('Join Newsletter') }}</h6>
                        <p class="footer-newsletter-desc mb-10">
                            {{ translation('Subscribe to the newsletter for all the latest updates') }}
                        </p>
                        <form id="footer-newsletter-form" method="POST" action="{{ route('newsletter.subscribe') }}">
                            @csrf
                            <div class="newsletter-input-wrap">
                                <input type="email" name="email" id="newsletter-email" class="newsletter-input"
                                    placeholder="{{ translation('Enter your email') }}" required>
                                <button type="submit" class="newsletter-submit-btn">
                                    <i class="las la-paper-plane"></i> {{ translation('Subscribe') }}
                                </button>
                            </div>
                            <div id="newsletter-msg" class="footer-newsletter-msg"></div>
                        </form>
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
                                {{ translation('All copyright') }} &copy; {{ date('Y') }}
                                {{ get_setting('site_name') }}. {{ translation('All Rights Reserved.') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('footer-newsletter-form');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var btn = form.querySelector('button[type=submit]');
            var msg = document.getElementById('newsletter-msg');
            var email = document.getElementById('newsletter-email').value;

            btn.disabled = true;
            btn.textContent = 'Subscribing...';
            msg.style.display = 'none';
            msg.className = 'footer-newsletter-msg';

            fetch('{{ route('newsletter.subscribe') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        email: email
                    }),
                })
                .then(function(res) {
                    return res.json();
                })
                .then(function(data) {
                    msg.className = 'mt-2';
                    if (data.success) {
                        msg.classList.add('text-success');
                        msg.textContent = data.message;
                        document.getElementById('newsletter-email').value = '';
                    } else {
                        msg.classList.add('text-danger');
                        msg.textContent = data.message || 'Something went wrong.';
                    }
                    msg.style.display = 'block';
                })
                .catch(function() {
                    msg.className = 'mt-2 text-danger';
                    msg.textContent = 'Something went wrong. Please try again.';
                    msg.style.display = 'block';
                })
                .finally(function() {
                    btn.disabled = false;
                    btn.textContent = 'Subscribe';
                });
        });
    });
</script>
