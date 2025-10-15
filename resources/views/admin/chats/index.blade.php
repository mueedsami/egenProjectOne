@extends('layouts.app')
@section('title', 'Admin — Chats')

@section('content')
<section class="bg-stone-50 py-16">
  <div class="max-w-5xl mx-auto px-6">
    <h2 class="text-2xl font-semibold text-stone-800 mb-6">Customer Conversations</h2>

    <div class="bg-white rounded-2xl shadow-lg border border-stone-100">
      @forelse($chats as $chat)
        @php $latest = $chat->messages->first(); @endphp
        <a href="{{ route('admin.chats.show', $chat) }}"
           class="flex justify-between items-center px-6 py-4 border-b border-stone-100 hover:bg-stone-50 transition">
          <div>
            <p class="font-medium text-stone-800">{{ $chat->user?->name ?? 'User #'.$chat->user_id }}</p>
            <p class="text-stone-500 text-sm">
              {{ $latest?->message ? \Illuminate\Support\Str::limit($latest->message, 60) : 'No messages yet' }}
            </p>
          </div>
          <div class="text-xs text-stone-400">
            {{ $latest?->created_at?->diffForHumans() }}
          </div>
        </a>
      @empty
        <div class="text-center py-10 text-stone-400">No chats yet.</div>
      @endforelse
    </div>

    <div class="mt-6">{{ $chats->links() }}</div>
  </div>
</section>
@endsection
