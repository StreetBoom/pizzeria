@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <div class="row">
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
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="card-text">{{ $product->category->name }}</p>
                        <p class="card-text"><strong>Цена: {{ number_format($product->price, 2) }} ₽</strong></p>
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="quantity_{{ $product->id }}">Количество</label>
                                <input type="number" class="form-control" id="quantity_{{ $product->id }}"
                                       name="quantity" value="1" min="1">
                            </div>
                            <button type="submit" class="btn btn-primary">Добавить в корзину</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
@endsection
