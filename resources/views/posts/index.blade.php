@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">All Posts</h2>

<a href="{{ route('posts.create') }}"
   class="px-4 py-2 bg-blue-600 text-blue rounded mb-4 inline-block hover:bg-blue-700">+ Add Post</a>

@if (session('success'))
    <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="w-full border-collapse border border-gray-300">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 border border-gray-300 text-left">Title</th>
            <th class="p-2 border border-gray-300 text-left">Body</th>
            <th class="p-2 border border-gray-300 text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($posts as $post)
            <tr>
                <td class="p-2 border border-gray-300">{{ $post->title }}</td>
                <td class="p-2 border border-gray-300">{{ Str::limit($post->body, 100) }}</td>
                <td class="p-2 border border-gray-300 text-center">
                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="text-red-600 ml-2 hover:underline" onclick="return confirm('Delete this post?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center p-4 text-gray-600">No posts found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
