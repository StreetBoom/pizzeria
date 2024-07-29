@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Корзина</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($cartItems)
            <table class="table">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Количество</th>
                    <th>Категория</th>
                    <th>Цена</th>
                    <th>Всего</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['category'] }}</td>
                        <td>${{ $item['price'] }}</td>
                        <td>${{ $item['quantity'] * $item['price'] }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove', $item['productId']) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <h4>Общее количество: {{ $totalQuantity }}</h4>
                <h4>Общая стоимость: ${{ $totalPrice }}</h4>
            </div>

            @if(auth()->check())
                <a href="{{ route('order.create') }}">Оформить заказ</a>
            @else
                <a href="{{ route('login') }}">Войти</a>
            @endif
        @else
            <p>Ваша корзина пуста.</p>
        @endif
    </div>
@endsection
