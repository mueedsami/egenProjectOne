@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="container py-5">
    <h3 class="mb-3">Add Product</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @include('admin.products._form', ['submitLabel' => 'Create'])
    </form>
</div>
@endsection
