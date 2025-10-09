@extends('layouts.app')

@section('title', 'Ödeme')

@section('content')
<div class="container py-5">
    <h2>Ödeme</h2>

    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>Ürün</th>
                <th>Adet</th>
                <th>Toplam</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['price'] * $item['quantity'], 2) }} ₺</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <button type="submit" class="btn btn-success">Siparişi Tamamla</button>
    </form>
</div>
@endsection
