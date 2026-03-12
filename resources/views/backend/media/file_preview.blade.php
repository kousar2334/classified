@if ($files->count() == 1)
    <div class="single-media-details mt-30 mt-md-0">
        <div class="file-preview p-2 border-bottom">
            @if (
                $files[0]->mime_type == 'png' ||
                    $files[0]->mime_type == 'jpg' ||
                    $files[0]->mime_type == 'jpeg' ||
                    $files[0]->mime_type == 'gif' ||
                    $files[0]->mime_type == 'webp')
                <img src="{{ asset(getFilePath($files[0]->path)) }}" alt="{{ $files[0]->alt }}" class="w-100" />
            @endif

            @if ($files[0]->mime_type == 'pdf')
                <h1 class="text-center mt-3">Pdf</h1>
            @endif

        </div>
        <div class="single-media-info p-2">
            <div class="media-form">
                <p>{{ translation('Name') }}</p>
                <span>{{ $files[0]->title }}</span>
            </div>
            <div class="media-form">
                <p class="mb-1">{{ translation('Full URL') }}</p>
                <div class="input-group">
                    <input type="text" class="form-control media-url-input" readonly
                        value="{{ asset(getFilePath($files[0]->path)) }}">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary copy-url-btn"
                            title="{{ translation('Copy URL') }}">
                            <i class="fa fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="media-form">
                <p>{{ translation('File Type') }}</p>
                <span>{{ $files[0]->mime_type }}</span>
            </div>
            <div class="media-form">
                <p>{{ translation('Size') }}</p>
                <span>{{ number_format($files[0]->size, 2) }} {{ translation('KB') }}</span>
            </div>
            <div class="media-form">
                <p>{{ translation('Uploaded at') }}</p>
                <span>{{ $files[0]->created_at->format('d M Y') }}</span>
            </div>
            <div class="media-form">
                <p>{{ translation('Modified at') }}</p>
                <span>{{ $files[0]->updated_at->format('d M Y') }}</span>
            </div>
            @if ($files[0]->user != null)
                <div class="media-form">
                    <p>{{ translation('Uploaded By') }}</p>
                    <span>{{ $files[0]->user->name }}</span>
                </div>
            @endif
        </div>
        <form class="d-none">
            <div class="d-flex gap-10 justify-content-end flex-wrap mt-2">
                <button type="button" class="btn btn-link text-danger">
                    {{ translation('Delete Permanently') }}
                </button>
            </div>
        </form>
    </div>
@endif
@if ($files->count() > 1)
    <h6 class="media-attachments-filter-heading mb-2">
        {{ $files->count() }} {{ translation('items selected') }}
    </h6>
    <div class="row">
        @foreach ($files as $file)
            <div class="col-lg-4 gap-1">
                <img src="{{ asset(getFilePath($file->path)) }}" alt="{{ $file->alt }}" class="w-100" />
            </div>
        @endforeach
    </div>
@endif

@if ($files->count() == 0)
    <div class="no-media p-2 border-bottom text-center">
        <img src="{{ asset('/public/web-assets/backend/img/media/place_holder.jpg') }}" alt="No Media">
    </div>
@endif
