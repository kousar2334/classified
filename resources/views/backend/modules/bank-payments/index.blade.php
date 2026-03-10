@php
    $links = [['title' => 'Bank Payments', 'route' => '', 'active' => true]];
@endphp
@extends('backend.layouts.dashboard_layout')
@section('page-title')
    Bank Payments
@endsection
@section('page-content')
    <x-admin-page-header title="Bank Payments" :links="$links" />
    <section class="content">
        <div class="container-fluid">

            {{-- Stats --}}
            <div class="row mb-3">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $stats['total'] }}</h3>
                            <p>Total</p>
                        </div>
                        <div class="icon"><i class="fas fa-university"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $stats['pending'] }}</h3>
                            <p>Pending Approval</p>
                        </div>
                        <div class="icon"><i class="fas fa-clock"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $stats['approved'] }}</h3>
                            <p>Approved</p>
                        </div>
                        <div class="icon"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $stats['rejected'] }}</h3>
                            <p>Rejected</p>
                        </div>
                        <div class="icon"><i class="fas fa-times-circle"></i></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ translation('Bank Transfer Payments') }}</h3>
                    <div class="card-tools">
                        <form method="GET" action="{{ route('admin.bank.payments') }}" class="d-flex"
                            style="gap: 0.5rem;">
                            <input type="text" name="q" class="form-control form-control-sm"
                                placeholder="{{ translation('Search member or txn ref...') }}" value="{{ request('q') }}">
                            <select name="status" class="form-control form-control-sm" style="width: auto;">
                                <option value="">{{ translation('All Status') }}</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected
                                </option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">{{ translation('Search') }}</button>
                            @if (request('q') || request('status'))
                                <a href="{{ route('admin.bank.payments') }}"
                                    class="btn btn-secondary btn-sm">{{ translation('Reset') }}</a>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translation('Member') }}</th>
                                <th>{{ translation('Plan') }}</th>
                                <th>{{ translation('Amount') }}</th>
                                <th>{{ translation('Bank Txn Ref') }}</th>
                                <th>{{ translation('System Txn ID') }}</th>
                                <th>{{ translation('Slip') }}</th>
                                <th>{{ translation('Status') }}</th>
                                <th>{{ translation('Admin Note') }}</th>
                                <th>{{ translation('Submitted') }}</th>
                                <th class="text-right">{{ translation('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $key => $pay)
                                <tr @if ($pay->status === 'pending') class="table-warning" @endif>
                                    <td>{{ $payments->firstItem() + $key }}</td>
                                    <td>
                                        <strong>{{ $pay->user->name ?? '—' }}</strong><br>
                                        <small class="text-muted">{{ $pay->user->email ?? '' }}</small>
                                    </td>
                                    <td>{{ $pay->plan->title ?? '—' }}</td>
                                    <td><strong>${{ number_format($pay->amount, 2) }}</strong></td>
                                    <td>
                                        @if ($pay->bank_transaction_number)
                                            <code>{{ $pay->bank_transaction_number }}</code>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <code style="font-size: 0.75rem;">{{ $pay->transaction_id }}</code>
                                    </td>
                                    <td class="text-center">
                                        @if ($pay->bank_slip)
                                            <a href="{{ asset('storage/' . $pay->bank_slip) }}" target="_blank"
                                                class="btn btn-info btn-xs" title="{{ translation('View Slip') }}">
                                                <i class="fas fa-file-image"></i> {{ translation('View') }}
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pay->status === 'active')
                                            <span class="badge badge-success">{{ translation('Approved') }}</span>
                                        @elseif ($pay->status === 'pending')
                                            <span class="badge badge-warning">{{ translation('Pending') }}</span>
                                        @elseif ($pay->status === 'rejected')
                                            <span class="badge badge-danger">{{ translation('Rejected') }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($pay->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $pay->admin_note ?? '—' }}</small>
                                    </td>
                                    <td>{{ $pay->created_at->format('M d, Y') }}<br>
                                        <small class="text-muted">{{ $pay->created_at->format('h:i A') }}</small>
                                    </td>
                                    <td class="text-right" style="white-space: nowrap;">
                                        @if ($pay->status === 'pending')
                                            <button class="btn btn-success btn-sm approve-item"
                                                data-id="{{ $pay->id }}" data-name="{{ $pay->user->name ?? '' }}"
                                                data-plan="{{ $pay->plan->title ?? '' }}"
                                                data-ref="{{ $pay->bank_transaction_number }}"
                                                title="{{ translation('Approve') }}">
                                                <i class="fas fa-check"></i> {{ translation('Approve') }}
                                            </button>
                                            <button class="btn btn-warning btn-sm reject-item"
                                                data-id="{{ $pay->id }}" data-name="{{ $pay->user->name ?? '' }}"
                                                data-plan="{{ $pay->plan->title ?? '' }}"
                                                data-ref="{{ $pay->bank_transaction_number }}"
                                                title="{{ translation('Reject') }}">
                                                <i class="fas fa-times"></i> {{ translation('Reject') }}
                                            </button>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-3">
                                        {{ translation('No bank transfer payments found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($payments->hasPages())
                        <div class="p-3">
                            {{ $payments->withQueryString()->onEachSide(1)->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

    {{-- Approve Modal --}}
    <div class="modal fade" id="approve-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h4 class="modal-title h6">
                        <i class="fas fa-check-circle mr-2"></i>{{ translation('Approve Payment') }}
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('admin.bank.payments.approve') }}">
                    @csrf
                    <input type="hidden" id="approve-id" name="id">
                    <div class="modal-body">
                        <p class="mb-1">
                            {{ translation('Approve payment from') }} <strong id="approve-name"></strong>
                            {{ translation('for plan') }} <strong id="approve-plan"></strong>?
                        </p>
                        <p class="text-muted mb-3">
                            {{ translation('Bank Txn Ref:') }} <code id="approve-ref"></code>
                        </p>
                        <div class="form-group mb-0">
                            <label>{{ translation('Admin Note (optional, sent to user)') }}</label>
                            <textarea name="admin_note" class="form-control" rows="2" placeholder="e.g. Payment verified successfully."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ translation('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check mr-1"></i> {{ translation('Approve & Activate') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    <div class="modal fade" id="reject-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title h6">
                        <i class="fas fa-times-circle mr-2"></i>{{ translation('Reject Payment') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form method="POST" action="{{ route('admin.bank.payments.reject') }}">
                    @csrf
                    <input type="hidden" id="reject-id" name="id">
                    <div class="modal-body">
                        <p class="mb-1">
                            {{ translation('Reject payment from') }} <strong id="reject-name"></strong>
                            {{ translation('for plan') }} <strong id="reject-plan"></strong>?
                        </p>
                        <p class="text-muted mb-3">
                            {{ translation('Bank Txn Ref:') }} <code id="reject-ref"></code>
                        </p>
                        <div class="form-group mb-0">
                            <label>{{ translation('Rejection Reason (sent to user)') }}</label>
                            <textarea name="admin_note" class="form-control" rows="2"
                                placeholder="e.g. Payment slip could not be verified."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ translation('Cancel') }}</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-times mr-1"></i> {{ translation('Reject') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        (function($) {
            "use strict";

            $('.approve-item').on('click', function() {
                $('#approve-id').val($(this).data('id'));
                $('#approve-name').text($(this).data('name'));
                $('#approve-plan').text($(this).data('plan'));
                $('#approve-ref').text($(this).data('ref') || '—');
                $('#approve-modal').modal('show');
            });

            $('.reject-item').on('click', function() {
                $('#reject-id').val($(this).data('id'));
                $('#reject-name').text($(this).data('name'));
                $('#reject-plan').text($(this).data('plan'));
                $('#reject-ref').text($(this).data('ref') || '—');
                $('#reject-modal').modal('show');
            });
        })(jQuery);
    </script>
@endsection
