@props(['categories'])

@if ($categories->count() > 0)
    @php
        $catBg = [
            'linear-gradient(145deg,#fde8d8,#f9c7a8)',
            'linear-gradient(145deg,#daeaff,#b8d4ff)',
            'linear-gradient(145deg,#d6f5e8,#a8e6cc)',
            'linear-gradient(145deg,#f0deff,#d9b8ff)',
            'linear-gradient(145deg,#fff3cc,#ffe080)',
            'linear-gradient(145deg,#ffe0eb,#ffb3c6)',
            'linear-gradient(145deg,#d0f0ff,#8ed8f8)',
            'linear-gradient(145deg,#e8f5d0,#c3e89a)',
            'linear-gradient(145deg,#ffd6c8,#ffaa8a)',
            'linear-gradient(145deg,#d8e4ff,#a0b8f8)',
            'linear-gradient(145deg,#d6faf5,#90e8d8)',
            'linear-gradient(145deg,#fde8f8,#f5b8e8)',
        ];
    @endphp
    <section class="browse-categories-section" data-padding-top="50" data-padding-bottom="50">
        <div class="container">
            <div class="titleWithBtn d-flex justify-content-between align-items-center mb-40">
                <h2 class="head3">{{ p_trans('home_categories_title', null, 'Browse Categories') }}</h2>
            </div>
            <div class="row g-3">
                @foreach ($categories as $category)
                    @php $bg = $catBg[$loop->index % count($catBg)]; @endphp
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-6">
                        <a href="{{ route('ad.listing.page', $category->permalink) }}"
                            class="cat-thumb-card text-decoration-none">
                            <div class="cat-thumb-img" style="background:{{ $bg }};">
                                <img src="{{ asset(getFilePath($category->icon)) }}" alt="{{ $category->title }}" />
                            </div>
                            <div class="cat-thumb-info">
                                <div class="cat-thumb-name">{{ $category->title }}</div>
                                <div class="cat-thumb-count">
                                    {{ number_format($category->ads_count) }} {{ translation('ads') ?? 'ads' }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
