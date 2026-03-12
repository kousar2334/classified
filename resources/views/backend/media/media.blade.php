@if ($multiple)
    <input type="hidden" name="{{ $name }}" id="input-{{ $name }}" value="{{ $value }}">
    <div class="d-flex flex-wrap multi-media-thumbs" id="multi-thumbs-{{ $name }}">
        @php $multiPaths = $value ? array_filter(array_map('trim', explode(',', $value))) : []; @endphp
        @if (count($multiPaths) > 0)
            @foreach ($multiPaths as $path)
                <div class="media-input-container" data-path="{{ $path }}">
                    <img src="{{ asset(getFilePath($path, true)) }}" class="media-input-preview" alt="">
                    <button type="button" class="input-remove-btn multi-remove-btn" data-input="{{ $name }}"
                        data-path="{{ $path }}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endforeach
        @else
            <div class="multi-media-placeholder" id="multi-placeholder-{{ $name }}">
                <i class="fas fa-images"></i>
                <span>{{ translation('No images selected') }}</span>
            </div>
        @endif
    </div>
    <div class="image-box-actions mt-1">
        <button type="button" class="btn-link bg-transparent border-0 media-choose-btn" data-toggle="modal"
            data-target="#mediaManagerModal"
            onclick="getMediaModalData('{{ $name }}', {{ $media_ids }}, 'true')">
            {{ translation('Choose Files') }}
        </button>
    </div>
@else
    <input type="hidden" name="{{ $name }}" id="input-{{ $name }}" value="{{ $value }}">
    <div class="image-box">
        <div class="d-flex flex-wrap gap-10">
            <div class="media-input-container {{ $width == '100' ? 'w-100' : '' }}">
                <img src="{{ asset(getFilePath($value, true)) }}" alt="{{ $name }}" width="150"
                    class="media-input-preview {{ $width == '100' ? 'w-100' : '' }}"
                    id="media-input-preview-{{ $name }}" />
                <button type="button" title="Remove {{ $name }}" class="input-remove-btn"
                    onclick="removeFileInputValue('{{ $name }}','{{ getPlaceHolder() }}', 'false')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="image-box-actions">
            <button type="button" class="btn-link bg-transparent border-0 media-choose-btn" data-toggle="modal"
                data-target="#mediaManagerModal"
                onclick="getMediaModalData('{{ $name }}', {{ $media_ids }}, 'false')">
                {{ translation('Chosse File') }}
            </button>
        </div>
    </div>
@endif
