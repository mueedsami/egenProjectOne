<!-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Welcome, {{ Auth::user()->name }} 👋
                    </h3>

                    <p class="text-gray-700 mb-6">
                        You’re successfully logged in!
                    </p>

                    <div class="mb-6">
                        <a href="{{ route('posts.index') }}"
                            class="px-4 py-2 bg-blue-200 text-white font-semibold rounded hover:bg-blue-500">
                            Manage Your Posts
                        </a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> -->


@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    Welcome, {{ Auth::user()->name }} 👋
                </h3>
                <p class="text-gray-700 mb-4">You're successfully logged in!</p>

                {{-- Create Post button --}}
                <a href="{{ route('posts.create') }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-blue rounded hover:bg-blue-700">
                    + Create New Post
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
