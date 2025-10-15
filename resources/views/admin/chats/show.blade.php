@extends('layouts.app')
@section('title', 'Admin · Chat — '.($chat->user?->name ?? 'User #'.$chat->user_id))

@section('content')
<section class="bg-stone-50 py-16">
  <div class="max-w-3xl mx-auto px-6">
    <div class="bg-white rounded-2xl shadow-lg border border-stone-100 overflow-hidden">
      {{-- Header --}}
      <div class="flex justify-between items-center bg-amber-600 text-white px-6 py-4">
        <div>
          <strong>Chat with:</strong> {{ $chat->user?->name ?? 'User #'.$chat->user_id }}
        </div>
        <a href="{{ route('admin.chats.index') }}"
           class="text-white bg-amber-700 hover:bg-amber-800 text-xs px-3 py-1 rounded-md transition">
          ← Back
        </a>
      </div>

      {{-- Chat Box --}}
      <div id="chat-box" class="h-[460px] overflow-y-auto px-6 py-5 bg-stone-50">
        @forelse($chat->messages as $m)
          <div class="flex mb-3 {{ $m->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-[75%] rounded-2xl px-4 py-2 shadow-sm {{ $m->sender_id === auth()->id() ? 'bg-amber-600 text-white rounded-br-none' : 'bg-white text-stone-800 border border-stone-200 rounded-bl-none' }}">
              {{ $m->message }}
              <div class="text-xs text-right mt-1 text-white">{{ $m->created_at->format('H:i') }}</div>
            </div>
          </div>
        @empty
          <div class="text-center text-stone-400 py-32">No messages yet.</div>
        @endforelse
      </div>

      {{-- Input --}}
      <div class="border-t border-stone-200 bg-white p-4">
        <form id="adminSendForm" class="flex gap-3">
          @csrf
          <input type="text" name="message" placeholder="Type a reply..."
                 class="flex-1 border border-stone-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-amber-500 focus:outline-none" required>
          <button class="bg-amber-600 hover:bg-amber-700 text-white px-6 rounded-lg font-medium transition">Send</button>
        </form>
      </div>
    </div>
  </div>
</section>

{{-- Pusher --}}
<script src="https://js.pusher.com/8.2/pusher.min.js"></script>
<script>
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
    chatBox.insertAdjacentHTML('beforeend', `
      <div class="flex justify-end mb-3">
        <div class="max-w-[75%] rounded-2xl px-4 py-2 bg-amber-600 text-white rounded-br-none shadow-sm">
          ${payload.message.message}
          <div class="text-xs text-stone-400 text-right mt-1">${new Date().toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</div>
        </div>
      </div>`);
    chatBox.scrollTop = chatBox.scrollHeight;
    form.reset();
  }
});

const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', { cluster: '{{ env('PUSHER_APP_CLUSTER') }}' });
const channel = pusher.subscribe('chat.{{ $chat->id }}');
channel.bind('App\\Events\\MessageSent', function(data) {
  const chatBox = document.querySelector('#chat-box');
  chatBox.insertAdjacentHTML('beforeend', `
    <div class="flex justify-start mb-3">
      <div class="max-w-[75%] rounded-2xl px-4 py-2 bg-white border border-stone-200 text-stone-800 rounded-bl-none shadow-sm">
        ${data.message}
        <div class="text-xs text-stone-400 mt-1">${new Date(data.created_at).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'})}</div>
      </div>
    </div>`);
  chatBox.scrollTop = chatBox.scrollHeight;
});
</script>
@endsection
