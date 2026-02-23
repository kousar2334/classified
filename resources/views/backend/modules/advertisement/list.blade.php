@php
    $links = [
        [
            'title' => 'Advertisement',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    Advertisements
@endsection
@section('page-style')
    <style>
        .ad-type-fields {
            display: none;
        }

        .ad-type-fields.active {
            display: block;
        }
    </style>
@endsection
@section('page-content')
    <x-admin-page-header title="Advertisements" :links="$links" />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('Manage Advertisements') }}</h3>
                            <button class="btn btn-success btn-sm float-right text-white" data-toggle="modal"
                                data-target="#create-ad-modal">
                                {{ translation('Add New Advertisement') }}
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ translation('#') }}</th>
                                        <th>{{ translation('Title') }}</th>
                                        <th>{{ translation('Position') }}</th>
                                        <th>{{ translation('Type') }}</th>
                                        <th>{{ translation('Status') }}</th>
                                        <th>{{ translation('Dates') }}</th>
                                        <th>{{ translation('Order') }}</th>
                                        <th class="text-center">{{ translation('Views') }}</th>
                                        <th class="text-center">{{ translation('Clicks') }}</th>
                                        <th class="text-right">{{ translation('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($advertisements as $key => $advertisement)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $advertisement->title }}</td>
                                            <td>
                                                @php
                                                    $positionLabels = [
                                                        'home_top' => [
                                                            'label' => 'Homepage — After Hero',
                                                            'badge' => 'badge-info',
                                                        ],
                                                        'listing_top' => [
                                                            'label' => 'Listing — Top',
                                                            'badge' => 'badge-primary',
                                                        ],
                                                        'details_sidebar' => [
                                                            'label' => 'Details — Sidebar',
                                                            'badge' => 'badge-secondary',
                                                        ],
                                                    ];
                                                    $pos = $positionLabels[$advertisement->position] ?? [
                                                        'label' => $advertisement->position,
                                                        'badge' => 'badge-dark',
                                                    ];
                                                @endphp
                                                <span class="badge {{ $pos['badge'] }}">{{ $pos['label'] }}</span>
                                            </td>
                                            <td>
                                                @if ($advertisement->type === 'image')
                                                    <span class="badge badge-warning">Image</span>
                                                @else
                                                    <span class="badge badge-dark">HTML / Code</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($advertisement->status == 1)
                                                    <span class="badge badge-success">{{ translation('Active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ translation('Inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($advertisement->start_date || $advertisement->end_date)
                                                    <small>
                                                        {{ $advertisement->start_date ? $advertisement->start_date->format('d M Y') : '—' }}
                                                        →
                                                        {{ $advertisement->end_date ? $advertisement->end_date->format('d M Y') : '∞' }}
                                                    </small>
                                                @else
                                                    <small class="text-muted">Always</small>
                                                @endif
                                            </td>
                                            <td>{{ $advertisement->sort_order }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-info">
                                                    {{ number_format($advertisement->total_impressions ?? 0) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-success">
                                                    {{ number_format($advertisement->total_clicks ?? 0) }}
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-default">{{ translation('Action') }}</button>
                                                    <button type="button"
                                                        class="btn btn-default dropdown-toggle dropdown-hover dropdown-icon"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.advertisement.analytics', $advertisement->id) }}">
                                                            {{ translation('Analytics') }}
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <button class="dropdown-item edit-ad-btn"
                                                            data-id="{{ $advertisement->id }}">
                                                            {{ translation('Edit') }}
                                                        </button>
                                                        <div class="dropdown-divider"></div>
                                                        <button class="dropdown-item delete-ad-btn"
                                                            data-id="{{ $advertisement->id }}">
                                                            {{ translation('Delete') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">
                                                <div class="text-center">{{ translation('No advertisements found') }}</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @if ($advertisements->hasPages())
                                <div class="p-3">
                                    {{ $advertisements->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================
             CREATE MODAL
        ============================================================ --}}
        <div class="modal fade" id="create-ad-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ translation('New Advertisement') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="create-ad-form">
                            <div class="form-row">
                                <div class="form-group col-lg-8">
                                    <label class="black font-14">{{ translation('Title') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control"
                                        placeholder="{{ translation('Internal label e.g. Homepage Top Banner') }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label class="black font-14">{{ translation('Sort Order') }}</label>
                                    <input type="number" name="sort_order" class="form-control" value="0"
                                        min="0">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translation('Position') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="position" class="form-control">
                                        <option value="">-- Select Position --</option>
                                        <option value="home_top">Homepage — After Hero Banner</option>
                                        <option value="listing_top">Listing Page — Top of Results</option>
                                        <option value="details_sidebar">Ad Details — Sidebar</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translation('Status') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="1">{{ translation('Active') }}</option>
                                        <option value="2">{{ translation('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translation('Start Date') }}</label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="black font-14">{{ translation('End Date') }}</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="black font-14">{{ translation('Ad Type') }} <span
                                        class="text-danger">*</span></label>
                                <select name="type" id="create-type-select" class="form-control">
                                    <option value="">-- Select Type --</option>
                                    <option value="image">Image Banner</option>
                                    <option value="html">HTML / Google AdSense Code</option>
                                </select>
                            </div>

                            {{-- Image fields --}}
                            <div id="create-image-fields" class="ad-type-fields">
                                <div class="form-group">
                                    <label class="black font-14">{{ translation('Banner Image') }} <span
                                            class="text-danger">*</span></label>
                                    <x-media name="image_path" value=""></x-media>
                                </div>
                                <div class="form-group">
                                    <label class="black font-14">{{ translation('Click-through URL') }}</label>
                                    <input type="url" name="click_url" class="form-control"
                                        placeholder="https://example.com (optional)">
                                </div>
                            </div>

                            {{-- HTML / AdSense fields --}}
                            <div id="create-html-fields" class="ad-type-fields">
                                <div class="form-group">
                                    <label class="black font-14">{{ translation('Ad Code (HTML / Google AdSense)') }}
                                        <span class="text-danger">*</span></label>
                                    <textarea name="html_code" class="form-control" rows="8"
                                        placeholder="Paste your Google AdSense code, ad script, or any HTML here..."></textarea>
                                    <small class="text-muted">Tip: Paste your &lt;script&gt; or &lt;ins&gt; AdSense tag
                                        here.</small>
                                </div>
                            </div>

                            <div class="btn-area d-flex justify-content-between">
                                <button type="submit"
                                    class="btn btn-primary mt-2">{{ translation('Save Advertisement') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- ============================================================
             EDIT MODAL
        ============================================================ --}}
        <div class="modal fade" id="edit-ad-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ translation('Edit Advertisement') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ad-edit-content"></div>
                </div>
            </div>
        </div>
        {{-- ============================================================
             DELETE MODAL
        ============================================================ --}}
        <div class="modal fade" id="delete-ad-modal">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title h6">{{ translation('Delete Confirmation') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h4 class="mt-1 h6 my-2">{{ translation('Are you sure to delete?') }}</h4>
                        <form method="POST" action="{{ route('admin.advertisement.delete') }}">
                            @csrf
                            <input type="hidden" id="delete-ad-id" name="id">
                            <button type="button" class="btn mt-2 btn-danger"
                                data-dismiss="modal">{{ translation('Cancel') }}</button>
                            <button type="submit" class="btn btn-success mt-2">{{ translation('Delete') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-script')
    <script>
        (function($) {
            "use strict";

            // ── Type toggle (create form) ────────────────────────────────
            function toggleCreateTypeFields(val) {
                $('#create-image-fields, #create-html-fields').removeClass('active');
                if (val === 'image') {
                    $('#create-image-fields').addClass('active');
                } else if (val === 'html') {
                    $('#create-html-fields').addClass('active');
                }
            }
            $('#create-type-select').on('change', function() {
                toggleCreateTypeFields($(this).val());
            });

            // ── Create form submit ───────────────────────────────────────
            $('#create-ad-form').submit(function(e) {
                e.preventDefault();
                $(document).find('.invalid-input').remove();
                $(document).find('.form-control').removeClass('is-invalid');
                var formData = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ route('admin.advertisement.store') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Advertisement created successfully', 'Success');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'Failed to create advertisement',
                                'Error');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').addClass(
                                    'is-invalid');
                                $(document).find('[name=' + field_name + ']').after(
                                    '<div class="error text-danger mb-0 invalid-input">' +
                                    error + '</div>'
                                );
                            });
                        } else {
                            toastr.error('Failed to create advertisement', 'Error');
                        }
                    }
                });
            });

            // ── Edit button ──────────────────────────────────────────────
            $(document).on('click', '.edit-ad-btn', function(e) {
                e.preventDefault();
                var ad_id = $(this).data('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ route('admin.advertisement.edit') }}',
                    data: {
                        id: ad_id
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.ad-edit-content').html(response.html);
                            $('#edit-ad-modal').modal('show');
                        } else {
                            toastr.error('Failed to load advertisement', 'Error');
                        }
                    },
                    error: function() {
                        toastr.error('Failed to load advertisement', 'Error');
                    }
                });
            });

            // ── Edit form submit (delegated) ─────────────────────────────
            $(document).on('submit', '#edit-ad-form', function(e) {
                e.preventDefault();
                $(document).find('.invalid-input').remove();
                $(document).find('.form-control').removeClass('is-invalid');
                var formData = new FormData(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: 'POST',
                    url: '{{ route('admin.advertisement.update') }}',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success('Advertisement updated successfully', 'Success');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'Update failed', 'Error');
                        }
                    },
                    error: function(response) {
                        if (response.status === 422) {
                            $.each(response.responseJSON.errors, function(field_name, error) {
                                $(document).find('[name=' + field_name + ']').addClass(
                                    'is-invalid');
                                $(document).find('[name=' + field_name + ']').after(
                                    '<div class="error text-danger mb-0 invalid-input">' +
                                    error + '</div>'
                                );
                            });
                        } else {
                            toastr.error('Update failed', 'Error');
                        }
                    }
                });
            });

            // ── Delete button ────────────────────────────────────────────
            $(document).on('click', '.delete-ad-btn', function(e) {
                e.preventDefault();
                $('#delete-ad-id').val($(this).data('id'));
                $('#delete-ad-modal').modal('show');
            });

        })(jQuery);
    </script>
@endsection
