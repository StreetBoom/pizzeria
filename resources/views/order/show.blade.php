@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Детали заказа #{{ $order->id }}</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Сумма: {{ $order->total }} ₽</h5>
                <p class="card-text">Статус: {{ ucfirst($order->status) }}</p>
                <p class="card-text">Телефон: {{ $order->phone }}</p>
                <p class="card-text">Email: {{ $order->email }}</p>
                <p class="card-text">Адрес: {{ $order->address }}</p>
                <p class="card-text">Время доставки: {{ $order->delivery_time ? $order->delivery_time->format('d.m.Y H:i') : 'Не установлено' }}</p>
            </div>
        </div>

        <h2>Содержимое заказа</h2>
        @if(empty($items))
            <p>В этом заказе нет товаров.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Название</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Сумма</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['price'] }} ₽</td>
                        <td>{{ $item['quantity'] * $item['price'] }} ₽</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('profile.show') }}" class="btn btn-secondary mt-3">В профиль</a>
    </div>
@endsection
