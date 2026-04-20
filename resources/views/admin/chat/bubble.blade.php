{{-- resources/views/admin/chat/_bubble.blade.php --}}
<div style="display:flex;flex-direction:column;align-items:{{ $isOwn ? 'flex-end' : 'flex-start' }}">
    @if(!$isOwn)
    <small class="text-muted mb-1" style="font-size:11px;padding-left:4px">
        {{ $msg->sender_type === 'user' ? ($msg->user?->name ?? 'User') : ($chatSession->guest_name ?? 'Guest') }}
    </small>
    @endif
    <div style="max-width:75%;background:{{ $isOwn ? '#198754' : '#ffffff' }};
                color:{{ $isOwn ? '#fff' : '#222' }};
                padding:10px 14px;border-radius:16px;
                {{ $isOwn ? 'border-bottom-right-radius:4px' : 'border-bottom-left-radius:4px' }};
                font-size:13.5px;line-height:1.55;
                box-shadow:0 1px 4px rgba(0,0,0,.08)">
        {{ $msg->message }}
    </div>
    <small style="color:#aaa;font-size:10.5px;margin-top:3px">
        {{ $msg->created_at->format('h:i A') }}
    </small>
</div>
