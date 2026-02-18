@extends('frontend.layouts.master')
@section('meta')
    <title>Messages - {{ get_setting('site_name') }}</title>
    <style>
        .messages-page { padding: 40px 0; }
        .msg-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); overflow: hidden; }
        .msg-card-header { padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; }
        .msg-card-header h5 { margin: 0; font-weight: 600; font-size: 16px; }
        .msg-list { list-style: none; margin: 0; padding: 0; }
        .msg-list-item { display: flex; align-items: center; gap: 14px; padding: 16px 24px; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: inherit; transition: background .15s; }
        .msg-list-item:hover { background: #f8fafc; }
        .msg-list-item.unread { background: #f0f7ff; }
        .msg-avatar { width: 48px; height: 48px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
        .msg-avatar-placeholder { width: 48px; height: 48px; border-radius: 50%; background: var(--main-color-one, #3B82F6); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 18px; font-weight: 600; flex-shrink: 0; }
        .msg-info { flex: 1; min-width: 0; }
        .msg-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
        .msg-name { font-weight: 600; font-size: 14px; }
        .msg-time { font-size: 12px; color: #94a3b8; white-space: nowrap; }
        .msg-ad-title { font-size: 12px; color: #64748b; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .msg-preview { font-size: 13px; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .msg-badge { background: var(--main-color-one, #3B82F6); color: #fff; border-radius: 10px; font-size: 11px; padding: 2px 7px; font-weight: 600; flex-shrink: 0; }
        .empty-state { text-align: center; padding: 60px 24px; color: #94a3b8; }
        .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; }
        .dashboard-wrapper { display: flex; gap: 24px; min-height: 80vh; }
        .dashboard-content { flex: 1; min-width: 0; }
    </style>
@endsection

@section('content')
<div class="messages-page section-padding2">
    <div class="container-1310">
        <div class="dashboard-wrapper">
            @include('frontend.includes.navbar')
            <div class="dashboard-content">
                <div class="msg-card">
                    <div class="msg-card-header">
                        <h5>💬 My Messages</h5>
                        <span class="text-muted" style="font-size:13px;">{{ $chats->total() }} conversation(s)</span>
                    </div>

                    @if ($chats->isEmpty())
                        <div class="empty-state">
                            <i class="las la-comments"></i>
                            <p>No conversations yet.</p>
                            <a href="{{ route('ad.listing.page') }}" class="btn btn-primary btn-sm mt-2">Browse Listings</a>
                        </div>
                    @else
                        <ul class="msg-list">
                            @foreach ($chats as $chat)
                                @php
                                    $other = $chat->sender_id === auth()->id() ? $chat->receiver : $chat->sender;
                                    $unread = $chat->unreadCountFor(auth()->id());
                                @endphp
                                <li>
                                    <a href="{{ route('member.messages.show', $chat->uid) }}"
                                       class="msg-list-item {{ $unread > 0 ? 'unread' : '' }}">
                                        @if ($other && $other->image)
                                            <img src="{{ getFilePath($other->image) }}" alt="{{ $other->name }}" class="msg-avatar">
                                        @else
                                            <div class="msg-avatar-placeholder">
                                                {{ strtoupper(substr($other->name ?? 'U', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="msg-info">
                                            <div class="msg-top">
                                                <span class="msg-name">{{ $other->name ?? 'Unknown' }}</span>
                                                <span class="msg-time">
                                                    {{ $chat->lastMessage ? $chat->lastMessage->created_at->diffForHumans() : '' }}
                                                </span>
                                            </div>
                                            @if ($chat->ad)
                                                <div class="msg-ad-title">Re: {{ $chat->ad->title }}</div>
                                            @endif
                                            <div class="msg-preview">
                                                {{ $chat->lastMessage ? Str::limit($chat->lastMessage->message, 70) : 'No messages yet' }}
                                            </div>
                                        </div>
                                        @if ($unread > 0)
                                            <span class="msg-badge">{{ $unread }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="p-3">
                            {{ $chats->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
