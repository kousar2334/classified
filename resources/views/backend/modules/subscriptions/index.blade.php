@php
    $links = [
        [
            'title' => 'Subscriptions',
            'route' => '',
            'active' => true,
        ],
    ];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    Subscriptions
@endsection
@section('page-content')
    <x-admin-page-header title="Subscriptions" :links="$links" />
    <section class="content">
        <div class="container-fluid">

            {{-- Stats Row --}}
            <div class="row mb-3">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $stats['total'] }}</h3>
                            <p>Total Subscriptions</p>
                        </div>
                        <div class="icon"><i class="fas fa-list"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $stats['active'] }}</h3>
                            <p>Active</p>
                        </div>
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $stats['pending'] }}</h3>
                            <p>Pending</p>
                        </div>
                        <div class="icon"><i class="fas fa-clock"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $stats['expired'] }}</h3>
                            <p>Expired</p>
                        </div>
                        <div class="icon"><i class="fas fa-times-circle"></i></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ translation('All Subscriptions') }}</h3>
                            <div class="card-tools">
                                <form method="GET" action="{{ route('admin.subscriptions.list') }}" class="d-flex"
                                    style="gap: 0.5rem;">
                                    <input type="text" name="q" class="form-control form-control-sm"
                                        placeholder="{{ translation('Search member...') }}" value="{{ request('q') }}">
                                    <select name="status" class="form-control form-control-sm" style="width: auto;">
                                        <option value="">{{ translation('All Status') }}</option>
                                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>
                                            Failed</option>
                                        <option value="cancelled"
                                            {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit"
                                        class="btn btn-primary btn-sm">{{ translation('Search') }}</button>
                                    @if (request('q') || request('status'))
                                        <a href="{{ route('admin.subscriptions.list') }}"
                                            class="btn btn-secondary btn-sm">{{ translation('Reset') }}</a>
                                    @endif
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ translation('#') }}</th>
                                        <th>{{ translation('Member') }}</th>
                                        <th>{{ translation('Plan') }}</th>
                                        <th>{{ translation('Transaction ID') }}</th>
                                        <th>{{ translation('Amount') }}</th>
                                        <th>{{ translation('Method') }}</th>
                                        <th>{{ translation('Status') }}</th>
                                        <th>{{ translation('Starts') }}</th>
                                        <th>{{ translation('Expires') }}</th>
                                        <th>{{ translation('Date') }}</th>
                                        <th class="text-right">{{ translation('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($subscriptions as $key => $sub)
                                        <tr>
                                            <td>{{ $subscriptions->firstItem() + $key }}</td>
                                            <td>
                                                <strong>{{ $sub->user->name ?? '—' }}</strong><br>
                                                <small class="text-muted">{{ $sub->user->email ?? '' }}</small>
                                            </td>
                                            <td>{{ $sub->plan->title ?? '—' }}</td>
                                            <td>
                                                <code style="font-size: 0.78rem;">{{ $sub->transaction_id }}</code>
                                            </td>
                                            <td>
                                                @if ($sub->amount > 0)
                                                    <strong>${{ number_format($sub->amount, 2) }}</strong>
                                                @else
                                                    <span class="badge badge-success">Free</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($sub->payment_method === 'sslcommerz')
                                                    <span class="badge badge-info">SSLCommerz</span>
                                                @else
                                                    <span class="badge badge-secondary">Trial</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $isExpired =
                                                        $sub->status === 'active' && $sub->expires_at?->isPast();
                                                @endphp
                                                @if ($sub->status === 'active' && !$isExpired)
                                                    <span class="badge badge-success">Active</span>
                                                @elseif ($sub->status === 'active' && $isExpired)
                                                    <span class="badge badge-secondary">Expired</span>
                                                @elseif ($sub->status === 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif ($sub->status === 'failed')
                                                    <span class="badge badge-danger">Failed</span>
                                                @elseif ($sub->status === 'cancelled')
                                                    <span class="badge badge-danger">Cancelled</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ ucfirst($sub->status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $sub->starts_at?->format('M d, Y') ?? '—' }}</td>
                                            <td>
                                                @if ($sub->expires_at)
                                                    {{ $sub->expires_at->format('M d, Y') }}
                                                    @if ($sub->expires_at->isFuture())
                                                        <br><small
                                                            class="text-success">{{ $sub->expires_at->diffForHumans() }}</small>
                                                    @else
                                                        <br><small class="text-danger">Expired</small>
                                                    @endif
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td>{{ $sub->created_at->format('M d, Y') }}</td>
                                            <td class="text-right">
                                                <button class="btn btn-danger btn-sm delete-item"
                                                    data-id="{{ $sub->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11">
                                                <div class="text-center">{{ translation('No subscriptions found') }}</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @if ($subscriptions->hasPages())
                                <div class="p-3">
                                    {{ $subscriptions->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="delete-item-modal">
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
                    <form method="POST" action="{{ route('admin.subscriptions.delete') }}">
                        @csrf
                        <input type="hidden" id="delete-item-id" name="id">
                        <button type="button" class="btn mt-2 btn-danger"
                            data-dismiss="modal">{{ translation('Cancel') }}</button>
                        <button type="submit" class="btn btn-success mt-2">{{ translation('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        (function($) {
            "use strict";

            $('.delete-item').on('click', function() {
                var id = $(this).data('id');
                $('#delete-item-id').val(id);
                $('#delete-item-modal').modal('show');
            });
        })(jQuery);
    </script>
@endsection
