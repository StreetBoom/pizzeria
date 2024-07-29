@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <h1 class="text-center text-primary mb-4">Оформление заказа</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('order.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="phone" class="form-label">Телефон:</label>
            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required>
            @error('phone')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Адрес:</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" required>
            @error('address')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="delivery_time" class="form-label">Время доставки:</label>
            <input type="datetime-local" id="delivery_time" name="deliveryTime" class="form-control" value="{{ old('delivery_time') }}" required>
            @error('delivery_time')
            <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Оформить заказ</button>
    </form>
</div>
@endsection
