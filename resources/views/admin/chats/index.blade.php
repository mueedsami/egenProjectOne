@extends('layouts.app')
@section('title','Admin · Chats')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Customer Chats</h4>
    </div>

    <div class="card shadow-sm">
        <div class="list-group list-group-flush">
            @forelse($chats as $chat)
                @php
                    $latest = $chat->messages->first();
                @endphp
                <a href="{{ route('admin.chats.show', $chat) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-semibold">{{ $chat->user?->name ?? 'User #'.$chat->user_id }}</div>
                        <div class="text-muted small">
                            {{ $latest?->message ? \Illuminate\Support\Str::limit($latest->message, 60) : 'No messages yet' }}
                        </div>
                    </div>
                    <div class="text-muted small">
                        {{ $latest?->created_at?->diffForHumans() }}
                    </div>
                </a>
            @empty
                <div class="p-4 text-center text-muted">No chats yet.</div>
            @endforelse
        </div>
    </div>

    <div class="mt-3">
        {{ $chats->links() }}
    </div>
</div>
@endsection
