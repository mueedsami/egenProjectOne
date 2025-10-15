@extends('layouts.app')

@section('title', 'Chat with Admin — Deshio')

@section('content')
<section class="bg-stone-50 py-16">
  <div class="max-w-3xl mx-auto px-6">
    <div class="bg-white rounded-2xl shadow-lg border border-stone-100 overflow-hidden">
      {{-- Header --}}
      <div class="bg-amber-600 text-white px-6 py-4 flex justify-between items-center">
        <h4 class="text-lg font-semibold">💬 Chat with Admin</h4>
        <small id="typing-indicator" class="opacity-70 hidden">Admin is typing...</small>
      </div>

      {{-- Chat Box --}}
      <div id="chat-box" class="h-[480px] overflow-y-auto px-6 py-5 bg-stone-50">
        @if($chat && $chat->messages->count())
          @foreach($chat->messages as $msg)
            <div class="flex mb-3 {{ $msg->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div
                    class="max-w-[75%] rounded-2xl px-4 py-2 shadow-sm 
                    {{ $msg->sender_id == auth()->id() 
                    ? 'bg-[#fbbf24] text-black shadow rounded-br-none' 
                    : 'bg-white text-black border border-stone-200 rounded-bl-none' }}">
      
                    <p class="leading-relaxed text-white">{{ $msg->message }}</p>
      
                    <div class="text-xs text-black text-right mt-1">
                        {{ $msg->created_at->format('H:i') }}
                        </div>
                    </div>
                </div>
            @endforeach


        @else
          <div class="text-center text-stone-400 py-32">
            No messages yet. Start the conversation 👋
          </div>
        @endif
      </div>

      {{-- Input Box --}}
      <div class="border-t border-stone-200 bg-white p-4">
        <form id="chatForm" class="flex gap-3">
          @csrf
          <input type="hidden" name="chat_id" value="{{ $chats->id ?? '' }}">
          <input type="text" name="message" id="messageInput" placeholder="Type your message..."
                 class="flex-1 border border-stone-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none" required>
          <button class="bg-amber-600 hover:bg-amber-700 text-white px-6 rounded-lg font-medium">Send</button>
        </form>
      </div>
    </div>
  </div>
</section>

{{-- Real-time logic (same as before) --}}
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
<script>
  const chatId = "{{ $chats->id ?? '' }}";
  const chatBox = document.querySelector('#chat-box');
  const typingIndicator = document.getElementById('typing-indicator');
  const messageInput = document.getElementById('messageInput');

  const scrollToBottom = () => chatBox.scrollTop = chatBox.scrollHeight;
  scrollToBottom();

  document.querySelector('#chatForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const msg = form.message.value.trim();
    if (!msg) return;

    const res = await fetch('{{ route("chat.send") }}', {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: new FormData(form)
    });

    if (res.ok) {
      chatBox.insertAdjacentHTML('beforeend', `
        <div class="flex justify-end mb-3">
          <div class="max-w-[75%] rounded-2xl px-4 py-2 bg-amber-600 text-white rounded-br-none shadow-sm">
            ${msg}
          </div>
        </div>`);
      scrollToBottom();
      form.reset();
    }
  });

  if (window.Echo) {
    Echo.channel('chat.' + chatId)
      .listen('.message.sent', (e) => {
        chatBox.insertAdjacentHTML('beforeend', `
          <div class="flex justify-start mb-3">
            <div class="max-w-[75%] rounded-2xl px-4 py-2 bg-white border border-stone-200 text-stone-800 rounded-bl-none shadow-sm">
              ${e.message.message}
            </div>
          </div>`);
        scrollToBottom();
      })
      .listenForWhisper('typing', () => {
        typingIndicator.classList.remove('hidden');
        clearTimeout(window._typingTimeout);
        window._typingTimeout = setTimeout(() => typingIndicator.classList.add('hidden'), 1200);
      });
  }
</script>
@endsection
