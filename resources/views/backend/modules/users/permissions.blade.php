@php
    $links = [
        ['title' => 'Users', 'route' => 'admin.users.list', 'active' => false],
        ['title' => 'Permissions', 'route' => '', 'active' => true],
    ];
    $grouped = $permissions->groupBy('module')->sortKeys();
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    {{ translation('Permissions') }}
@endsection
@section('page-style')
    <style>
        .module-card .card-header {
            background: #f4f6f9;
            padding: 0.6rem 1rem;
        }

        .module-card .card-title {
            font-size: 0.9rem;
            font-weight: 700;
            margin: 0;
        }

        .permission-badge {
            display: inline-block;
            background: #f4f6f9;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            padding: 2px 8px;
            font-size: 0.78rem;
            color: #495057;
            margin: 2px 2px 2px 0;
        }

        .search-highlight {
            background: #fff3cd;
        }

        #permission-search {
            max-width: 320px;
        }
    </style>
@endsection
@section('page-content')
    <x-admin-page-header title="Permissions" :links="$links" />
    <section class="content">
        <div class="container-fluid">

            {{-- Summary bar --}}
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <span class="badge badge-secondary px-3 py-2 mr-2" style="font-size:0.85rem;">
                                {{ $permissions->count() }} {{ translation('Total Permissions') }}
                            </span>
                            <span class="badge badge-secondary px-3 py-2" style="font-size:0.85rem;">
                                {{ $grouped->count() }} {{ translation('Modules') }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center">
                            <input type="text" id="permission-search" class="form-control form-control-sm"
                                placeholder="{{ translation('Search permissions...') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grouped permission cards --}}
            <div class="row" id="permission-groups">
                @foreach ($grouped as $module => $perms)
                    <div class="col-lg-6 col-xl-4 mb-4 permission-group-col" data-module="{{ strtolower($module) }}">
                        <div class="card module-card h-100 mb-0">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">{{ $module }}</h3>
                                <span class="badge badge-secondary">{{ $perms->count() }}</span>
                            </div>
                            <div class="card-body p-2">
                                <div class="permission-badges-wrap">
                                    @foreach ($perms as $perm)
                                        <span class="permission-badge permission-item"
                                            data-name="{{ strtolower($perm->name) }}">
                                            {{ $perm->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- No results message --}}
            <div id="no-results" class="text-center text-muted py-4" style="display:none;">
                <i class="fas fa-search fa-2x mb-2"></i>
                <p>{{ translation('No permissions found matching your search.') }}</p>
            </div>

        </div>
    </section>
@endsection

@section('page-script')
    <script>
        (function($) {
            "use strict";

            // Live search across permission names and module names
            $('#permission-search').on('keyup', function() {
                var query = $(this).val().toLowerCase().trim();
                var anyVisible = false;

                // Remove previous highlights
                $('.permission-item').removeClass('search-highlight');

                if (query === '') {
                    $('.permission-group-col').show();
                    $('#no-results').hide();
                    return;
                }

                $('.permission-group-col').each(function() {
                    var moduleName = $(this).data('module');
                    var items = $(this).find('.permission-item');
                    var moduleMatch = moduleName.includes(query);
                    var matchCount = 0;

                    items.each(function() {
                        var name = $(this).data('name');
                        if (name.includes(query) || moduleMatch) {
                            $(this).show().addClass('search-highlight');
                            matchCount++;
                        } else {
                            $(this).hide();
                        }
                    });

                    if (matchCount > 0 || moduleMatch) {
                        $(this).show();
                        anyVisible = true;
                        if (moduleMatch) items.show().addClass('search-highlight');
                    } else {
                        $(this).hide();
                    }
                });

                $('#no-results').toggle(!anyVisible);
            });

        })(jQuery);
    </script>
@endsection
