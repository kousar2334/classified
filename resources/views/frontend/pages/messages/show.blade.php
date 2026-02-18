@extends('frontend.layouts.master')
@section('meta')
    <title>Messages - {{ get_setting('site_name') }}</title>
    <style>
        .messages-page { padding: 40px 0; }
        .chat-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); display: flex; flex-direction: column; height: 75vh; }
        .chat-header { padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 12px; }
        .chat-header-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .chat-header-placeholder { width: 40px; height: 40px; border-radius: 50%; background: var(--main-color-one, #3B82F6); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px; font-weight: 600; }
        .chat-header-info { flex: 1; }
        .chat-header-name { font-weight: 600; font-size: 15px; margin: 0; }
        .chat-header-sub { font-size: 12px; color: #64748b; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 300px; }
        .chat-body { flex: 1; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; gap: 12px; }
        .msg-bubble-wrap { display: flex; gap: 8px; }
        .msg-bubble-wrap.mine { flex-direction: row-reverse; }
        .bubble-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; flex-shrink: 0; }
        .bubble-avatar-placeholder { width: 32px; height: 32px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; color: #64748b; flex-shrink: 0; }
        .bubble { max-width: 65%; }
        .bubble-text { padding: 10px 14px; border-radius: 16px; font-size: 14px; line-height: 1.5; word-break: break-word; }
        .msg-bubble-wrap:not(.mine) .bubble-text { background: #f1f5f9; color: #1e293b; border-top-left-radius: 4px; }
        .msg-bubble-wrap.mine .bubble-text { background: var(--main-color-one, #3B82F6); color: #fff; border-top-right-radius: 4px; }
        .bubble-time { font-size: 11px; color: #94a3b8; margin-top: 4px; }
        .msg-bubble-wrap.mine .bubble-time { text-align: right; }
        .chat-footer { padding: 16px 20px; border-top: 1px solid #f1f5f9; }
        .chat-footer form { display: flex; gap: 10px; align-items: flex-end; }
        .chat-footer textarea { flex: 1; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 14px; font-size: 14px; resize: none; outline: none; transition: border-color .2s; }
        .chat-footer textarea:focus { border-color: var(--main-color-one, #3B82F6); }
        .chat-footer button { background: var(--main-color-one, #3B82F6); color: #fff; border: none; border-radius: 10px; padding: 10px 20px; font-size: 14px; cursor: pointer; white-space: nowrap; }
        .chat-footer button:hover { opacity: .9; }
        .back-link { display: inline-flex; align-items: center; gap: 6px; font-size: 14px; color: #64748b; margin-bottom: 16px; text-decoration: none; }
        .back-link:hover { color: var(--main-color-one, #3B82F6); }
        .dashboard-wrapper { display: flex; gap: 24px; min-height: 80vh; }
        .dashboard-content { flex: 1; min-width: 0; }
        .ad-banner { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 0; }
        .ad-banner img { width: 40px; height: 40px; object-fit: cover; border-radius: 6px; }
        .ad-banner-title { font-size: 13px; font-weight: 600; color: #1e293b; }
        .ad-banner-price { font-size: 12px; color: #64748b; }
    </style>
@endsection

@section('content')
<div class="messages-page section-padding2">
    <div class="container-1310">
        <div class="dashboard-wrapper">
            @include('frontend.includes.navbar')
            <div class="dashboard-content">
                <a href="{{ route('member.messages.index') }}" class="back-link">
                    <i class="las la-arrow-left"></i> Back to messages
                </a>

                <div class="chat-card">
                    {{-- Header --}}
                    @php
                        $other = $chat->sender_id === auth()->id() ? $chat->receiver : $chat->sender;
                    @endphp
                    <div class="chat-header">
                        @if ($other && $other->image)
                            <img src="{{ getFilePath($other->image) }}" alt="{{ $other->name }}" class="chat-header-avatar">
                        @else
                            <div class="chat-header-placeholder">{{ strtoupper(substr($other->name ?? 'U', 0, 1)) }}</div>
                        @endif
                        <div class="chat-header-info">
                            <p class="chat-header-name">{{ $other->name ?? 'Unknown' }}</p>
                            @if ($chat->ad)
                                <p class="chat-header-sub">
                                    <a href="{{ route('ad.details.page', $chat->ad->uid) }}" target="_blank" style="color:inherit;">
                                        Re: {{ $chat->ad->title }}
                                    </a>
                                </p>
                            @endif
                        </div>
                        @if ($chat->ad && $chat->ad->thumbnail_image)
                            <div class="ad-banner ms-auto d-none d-md-flex">
                                <img src="{{ asset(getFilePath($chat->ad->thumbnail_image, false)) }}" alt="{{ $chat->ad->title }}">
                                <div>
                                    <div class="ad-banner-title">{{ Str::limit($chat->ad->title, 30) }}</div>
                                    <div class="ad-banner-price">${{ number_format($chat->ad->price, 2) }}</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Messages --}}
                    <div class="chat-body" id="chatBody">
                        @forelse ($chat->messages as $msg)
                            @php $isMine = $msg->sender_id === auth()->id(); @endphp
                            <div class="msg-bubble-wrap {{ $isMine ? 'mine' : '' }}">
                                @if ($msg->sender && $msg->sender->image)
                                    <img src="{{ getFilePath($msg->sender->image) }}" alt="{{ $msg->sender->name }}" class="bubble-avatar">
                                @else
                                    <div class="bubble-avatar-placeholder">{{ strtoupper(substr($msg->sender->name ?? 'U', 0, 1)) }}</div>
                                @endif
                                <div class="bubble">
                                    <div class="bubble-text">{{ $msg->message }}</div>
                                    <div class="bubble-time">{{ $msg->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted mt-auto mb-auto">No messages yet. Say hello!</div>
                        @endforelse
                    </div>

                    {{-- Reply Form --}}
                    <div class="chat-footer">
                        <form action="{{ route('member.messages.send', $chat->uid) }}" method="POST">
                            @csrf
                            <textarea name="message" rows="2" placeholder="Type a message..." required
                                      onkeydown="if(event.ctrlKey && event.key==='Enter') this.form.submit()">{{ old('message') }}</textarea>
                            <button type="submit">
                                <i class="las la-paper-plane"></i> Send
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    // Auto-scroll chat to bottom on load
    (function () {
        var body = document.getElementById('chatBody');
        if (body) body.scrollTop = body.scrollHeight;
    })();
</script>
@endsection
