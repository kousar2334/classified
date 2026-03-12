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
    <!--Media upload Tab-->
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
    <!-- End Media upload Tab -->

    <!--Media Listing Tab-->
    <div class="tab-pane fade show active" id="media-library" role="tabpanel" aria-labelledby="media-library-tab">
        <div class="media-container row m-0">
            <!--Media List-->
            <div class="media-list-wrapper col-lg-10 mt-1">
                <div class="media-list mt-0">
                    <div id="filtered_media">

                    </div>
                </div>
            </div>
            <!--End Media List-->
            <!--Media details-->
            <div class="media-preview-sidebar col-lg-2 border border-bottom-0 border-top-0 p-0 d-none d-lg-block"
                id="media-preview-section">
                <h6 class="media-attachments-filter-heading mb-2">
                    {{ translation('Media Details') }}
                </h6>
            </div>
            <!--End Media Details-->
        </div>

        <div class="row media-footer border-top pt-2 m-0">
            <div class="col-lg-10 text-center">
                <div class="d-flex justify-content-center gap-10" id="load_more">
                    <button type="button" class="btn btn-primary media-load-more-btn"
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
            </div>
            <div class="col-lg-2">
                <div class="d-flex justify-content-end gap-10">
                    <button type="button" class="btn btn-primary py-1 d-none media-input-insert-btn"
                        onclick="setMediaInputValue()">
                        {{ translation('Insert Media') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--End Media Listing Tab-->
</div>
