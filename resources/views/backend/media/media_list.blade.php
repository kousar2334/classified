<ul class="nav nav-tabs pl-20" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="media-library-tab" data-toggle="tab" href="#media-library" role="tab"
            aria-controls="media-library" aria-selected="false">{{ translation('Media Library') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="upload-files-tab" data-toggle="tab" href="#upload-files" role="tab"
            aria-controls="upload-files" aria-selected="true">{{ translation('Upload') }}</a>
    </li>
</ul>
<div class="tab-content" id="mediaTabContent">

    {{-- Upload Tab --}}
    <div class="tab-pane fade" id="upload-files" role="tabpanel" aria-labelledby="upload-files-tab">
        <div id="file-drop-area-wrappper" class="dz-wrapper">
            <form method="post" action="#" id="media-upload" enctype="multipart/form-data"
                class="dropzone media-upload">
                @csrf
                <div class="dz-message" data-dz-message>
                    <div class="dz-icon-wrap">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <p class="dz-label">{{ translation('Drop files here or click to upload') }}</p>
                    <p class="dz-sublabel">{{ translation('Drag and drop your files anywhere in this area') }}</p>
                    <span class="dz-hint">JPEG &bull; PNG &bull; GIF &bull; WEBP &bull; SVG &bull; PDF &bull; ZIP &bull;
                        MP4 &mdash; max 256 MB</span>
                </div>
            </form>
        </div>
    </div>

    {{-- Media Library Tab --}}
    <div class="tab-pane fade show active" id="media-library" role="tabpanel" aria-labelledby="media-library-tab">

        {{-- Toolbar: Search + Filter + Multi-select (single row) --}}
        <div class="media-toolbar border-bottom px-3 py-2">
            <div class="media-toolbar-inner">
                <div class="input-group input-group-sm media-search-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0 text-muted">
                            <i class="fas fa-search media-search-icon"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control form-control-sm border-left-0 media-search-input-field"
                        id="media-search-input" placeholder="{{ translation('Search files...') }}">
                    <div class="input-group-append d-none" id="media-search-clear-btn">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearMediaSearch()">
                            <i class="fas fa-times media-clear-icon"></i>
                        </button>
                    </div>
                </div>
                <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary media-filter-btn active"
                        data-type="all">{{ translation('All') }}</button>
                    <button type="button" class="btn btn-outline-secondary media-filter-btn"
                        data-type="image">{{ translation('Images') }}</button>
                    <button type="button" class="btn btn-outline-secondary media-filter-btn"
                        data-type="video">{{ translation('Videos') }}</button>
                    <button type="button" class="btn btn-outline-secondary media-filter-btn"
                        data-type="document">{{ translation('Docs') }}</button>
                </div>
                <div class="custom-control custom-switch ml-auto media-multiselect-toggle">
                    <input type="checkbox" class="custom-control-input" id="multi-select-toggle">
                    <label class="custom-control-label media-multiselect-label"
                        for="multi-select-toggle">{{ translation('Multi Select') }}</label>
                </div>
            </div>
        </div>

        <div class="media-container row m-0">

            {{-- Media grid --}}
            <div class="media-list-wrapper col-12 col-lg-10 mt-1 p-1">
                <div class="media-list mt-0">
                    <div id="filtered_media"></div>
                </div>
            </div>

            {{-- Preview sidebar: always visible, stacks below grid on mobile --}}
            <div class="media-preview-sidebar col-12 col-lg-2 border-left p-0" id="media-preview-section">
                <h6 class="media-attachments-filter-heading mb-2 px-2 pt-2">
                    {{ translation('Media Details') }}
                </h6>
            </div>

        </div>

        {{-- Footer: always side-by-side on all screen sizes --}}
        <div class="row media-footer border-top pt-2 pb-1 m-0 align-items-center">
            <div class="col-6 text-center">
                <button type="button" class="btn btn-sm btn-primary media-load-more-btn"
                    onclick="getMediaItemsList(true)">
                    <span class="media-load-more-btn-text">{{ translation('Load more') }}</span>
                    <div class="spinner">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </button>
            </div>
            <div class="col-6 text-right">
                <button type="button" class="btn btn-sm btn-success d-none media-input-insert-btn"
                    onclick="setMediaInputValue()">
                    <i class="fas fa-check mr-1"></i>{{ translation('Insert Media') }}
                </button>
            </div>
        </div>
    </div>

</div>
