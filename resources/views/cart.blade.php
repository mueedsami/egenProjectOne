@extends('layouts.app')

@section('title', 'Sepetim')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Sepetim</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(!empty($cart))
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ürün</th>
                    <th>Adet</th>
                    <th>Fiyat</th>
                    <th>Toplam</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $id => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['price'], 2) }} ₺</td>
                        <td>{{ number_format($item['price'] * $item['quantity'], 2) }} ₺</td>
                        <td><a href="{{ route('cart.remove', $id) }}" class="btn btn-danger btn-sm">Sil</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end">
            <a href="{{ route('checkout.index') }}" class="btn btn-primary">Ödemeye Geç</a>
        </div>
    @else
        <p>Sepetiniz boş.</p>
    @endif
</div>
@endsection
