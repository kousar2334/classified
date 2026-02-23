@php $isSidebar = isset($position) && $position === 'details_sidebar'; @endphp
@if (isset($advertisements) && $advertisements->count() > 0)
    <div class="ad-slot-wrapper ad-slot-{{ $position }}"
        style="{{ $isSidebar ? 'margin-bottom:16px;' : 'padding:20px 0;' }}">
        @if (!$isSidebar)
            <div class="container">
        @endif
        @foreach ($advertisements as $ad)
            @if ($ad->type === 'image' && $ad->image_path)
                <div class="text-center mb-2" data-ad-id="{{ $ad->id }}" data-ad-track="impression">
                    @if ($ad->click_url)
                        <a href="{{ $ad->click_url }}" target="_blank" rel="noopener sponsored"
                            data-ad-id="{{ $ad->id }}" data-ad-track="click">
                            <img src="{{ asset(getFilePath($ad->image_path, false)) }}" alt="{{ $ad->title }}"
                                style="max-width:100%;height:auto;border-radius:4px;">
                        </a>
                    @else
                        <img src="{{ asset(getFilePath($ad->image_path, false)) }}" alt="{{ $ad->title }}"
                            style="max-width:100%;height:auto;border-radius:4px;">
                    @endif
                </div>
            @elseif ($ad->type === 'html' && $ad->html_code)
                <div class="{{ $isSidebar ? '' : 'text-center' }} mb-2 ad-html-block" data-ad-id="{{ $ad->id }}"
                    data-ad-track="impression">
                    {!! $ad->html_code !!}
                </div>
            @endif
        @endforeach
        @if (!$isSidebar)
    </div>
@endif
</div>

<script>
    (function() {
        var csrfToken = document.querySelector('meta[name="csrf-token"]') ?
            document.querySelector('meta[name="csrf-token"]').getAttribute('content') :
            '';

        function sendTrack(type, adId) {
            var url = type === 'click' ?
                '{{ route('ad.track.click') }}' :
                '{{ route('ad.track.impression') }}';
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(adId),
                keepalive: true
            });
        }

        // Impressions — fire immediately (script runs right after ad elements are rendered)
        document.querySelectorAll('[data-ad-track="impression"]').forEach(function(el) {
            sendTrack('impression', el.dataset.adId);
        });

        // Clicks
        document.querySelectorAll('[data-ad-track="click"]').forEach(function(el) {
            el.addEventListener('click', function() {
                sendTrack('click', el.dataset.adId);
            });
        });
    }());
</script>
@endif
