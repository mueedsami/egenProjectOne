@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Edit Post</h2>

@if ($errors->any())
    <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('posts.update', $post) }}" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block font-medium">Title</label>
        <input type="text" name="title" class="border rounded w-full p-2" value="{{ old('title', $post->title) }}">
    </div>

    <div>
        <label class="block font-medium">Body</label>
        <textarea name="body" class="border rounded w-full p-2" rows="6">{{ old('body', $post->body) }}</textarea>
    </div>

    <button class="px-4 py-2 bg-blue-600 text-blue rounded hover:bg-blue-700">Update</button>
</form>
@endsection
