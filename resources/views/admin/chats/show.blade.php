@extends('layouts.app')
@section('title','Admin · Chat · '.($chat->user?->name ?? 'User #'.$chat->user_id))

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <strong>Chat with:</strong> {{ $chat->user?->name ?? 'User #'.$chat->user_id }}
            </div>
            <a href="{{ route('admin.chats.index') }}" class="btn btn-sm btn-outline-secondary">Back to Inbox</a>
        </div>

        <div class="card-body" id="chat-box" style="height: 450px; overflow-y:auto; background:#f8f9fa;">
            @forelse($chat->messages as $m)
                <div class="d-flex mb-2 {{ $m->sender_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                    <div class="p-2 rounded"
                         style="max-width:75%; background: {{ $m->sender_id === auth()->id() ? '#0d6efd' : '#e9ecef' }};
                                color: {{ $m->sender_id === auth()->id() ? 'white' : 'black' }};">
                        {{ $m->message }}
                        <div class="text-muted small mt-1 text-end">{{ $m->created_at->format('H:i') }}</div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">No messages yet.</div>
            @endforelse
        </div>

        <div class="card-footer">
            <form id="adminSendForm">
                @csrf
                <div class="input-group">
                    <input type="text" name="message" class="form-control" placeholder="Type a reply..." required>
                    <button class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Pusher --}}
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script>
    // Send via AJAX
    document.querySelector('#adminSendForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);

        const res = await fetch('{{ route("admin.chats.send", $chat) }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: data
        });

        if (res.ok) {
            const payload = await res.json();
            const chatBox = document.querySelector('#chat-box');

            const div = document.createElement('div');
            div.className = 'd-flex mb-2 justify-content-end';
            div.innerHTML = `<div class="p-2 rounded text-white" style="max-width:75%;background:#0d6efd;">
                ${payload.message.message}
                <div class="text-muted small mt-1 text-end">${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
            </div>`;
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight;
            form.reset();
        }
    });

    // Realtime receive
    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', { cluster: '{{ env('PUSHER_APP_CLUSTER') }}' });
    const channel = pusher.subscribe('chat.{{ $chat->id }}');

    channel.bind('App\\Events\\MessageSent', function(data) {
        // If it’s not the admin’s own message (broadcasted with toOthers), render as incoming
        const chatBox = document.querySelector('#chat-box');
        const bubble = document.createElement('div');
        bubble.className = 'd-flex mb-2 justify-content-start';
        bubble.innerHTML = `<div class="p-2 rounded" style="max-width:75%;background:#e9ecef;color:black;">
            ${data.message}
            <div class="text-muted small mt-1">${new Date(data.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
        </div>`;
        chatBox.appendChild(bubble);
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>
@endsection
