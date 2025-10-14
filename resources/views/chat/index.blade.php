@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">💬 Chat with Admin</h5>
            <small id="typing-indicator" class="text-muted small d-none">Admin is typing...</small>
        </div>

        {{-- Chat Messages --}}
        <div class="card-body" id="chat-box"
             style="height: 420px; overflow-y: auto; background: #f8f9fa; padding: 1rem;">
            @if($chat && $chat->messages->count())
                @foreach($chat->messages as $msg)
                    <div class="d-flex mb-2 {{ $msg->sender_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                        <div class="p-2 rounded shadow-sm"
                             style="max-width:75%;background-color:{{ $msg->sender_id == auth()->id() ? '#007bff' : '#e9ecef' }};
                                    color:{{ $msg->sender_id == auth()->id() ? 'white' : 'black' }};">
                            {{ $msg->message }}
                            <div class="text-muted small text-end mt-1">
                                {{ $msg->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center text-muted py-5">
                    No messages yet. Start the conversation 👋
                </div>
            @endif
        </div>

        {{-- Chat Input --}}
        <div class="card-footer bg-white">
            <form id="chatForm">
                @csrf
                <input type="hidden" name="chat_id" value="{{ $chats->id ?? '' }}">
                <div class="input-group">
                    <input type="text" name="message" id="messageInput" class="form-control"
                           placeholder="Type your message..." required autocomplete="off">
                    <button class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Pusher + Echo --}}
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
<script>
    const chatId = "{{ $chats->id ?? '' }}";
    const chatBox = document.querySelector('#chat-box');
    const typingIndicator = document.getElementById('typing-indicator');
    const messageInput = document.getElementById('messageInput');

    // Smooth auto-scroll
    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    scrollToBottom();

    // --- SEND MESSAGE VIA AJAX ---
    document.querySelector('#chatForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const form = e.target;
        const msg = form.message.value.trim();
        if (!msg) return;

        let res = await fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: new FormData(form)
        });

        if (res.ok) {
            const bubble = document.createElement('div');
            bubble.className = 'd-flex mb-2 justify-content-end';
            bubble.innerHTML = `
                <div class="p-2 rounded text-white shadow-sm" style="max-width:75%;background:#007bff;">
                    ${msg}
                </div>`;
            chatBox.appendChild(bubble);
            scrollToBottom();
            form.reset();
        }
    });

    // --- REAL-TIME LISTENER ---
    if (window.Echo) {
        Echo.channel('chat.' + chatId)
            .listen('.message.sent', (e) => {
                const msg = e.message.message;
                const bubble = document.createElement('div');
                bubble.className = 'd-flex mb-2 justify-content-start';
                bubble.innerHTML = `
                    <div class="p-2 rounded shadow-sm" style="max-width:75%;background:#e9ecef;">${msg}</div>`;
                chatBox.appendChild(bubble);
                scrollToBottom();
            })
            .listenForWhisper('typing', (e) => {
                typingIndicator.classList.remove('d-none');
                clearTimeout(window._typingTimeout);
                window._typingTimeout = setTimeout(() => typingIndicator.classList.add('d-none'), 1200);
            });
    }

    // --- TYPING WHISPER ---
    let typingTimer;
    messageInput.addEventListener('input', () => {
        if (window.Echo) {
            Echo.channel('chat.' + chatId)
                .whisper('typing', { user: '{{ auth()->user()->name }}' });
        }
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {}, 1000);
    });
</script>
@endsection
