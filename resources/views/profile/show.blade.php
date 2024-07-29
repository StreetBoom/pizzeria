@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Профиль пользователя</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Привет, {{ $user->name }}!</h5>
                <p class="card-text">Ваш email: {{ $user->email }}</p>
            </div>
        </div>

        <h2>Мои заказы</h2>

        @if($orders->isEmpty())
            <p>У вас еще нет заказов.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Дата создания</th>
                    <th scope="col">Время доставки</th>
                    <th scope="col">Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->total }} ₽</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $order->delivery_time ? $order->delivery_time->format('d.m.Y H:i') : 'Не установлено' }}</td>
                        <td>
                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary btn-sm">Посмотреть</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
