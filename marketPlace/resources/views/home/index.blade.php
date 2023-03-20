@extends('layouts.master')

@section('title', 'Home')

@section('content')

    <h1> Todos los productos </h1>

    <form class="form-order" action="{{ route('home.searchProduct') }}" method="post">
        <select name="order">
            <option value="asc">A-Z</option>
            <option value="asc">A-Z</option>
            <option value="desc" selected>Z-A</option>
        </select>
    </form>

    <ul class="products-section">
        @foreach ($products as $key => $product)
            <li class="product" id="{{ $product->id }}">
                <div class="product-image">
                    <a href="{{ route('product.show', ['id' => $product->id]) }}">
                        <img src="{{ asset('storage/img/' . $product->url) }}" />
                    </a>
                </div>
                <div class="product-details">
                    <a href="{{ route('product.show', ['id' => $product->id]) }}">
                        <p class="product-name"> {{ $product->name }} </p>
                        <p class="product-price"> {{ $product->price }}€ </p>
                    </a>
                </div>

                <input class="button-addToCart" type="button" value="Añadir" id="{{ $product->id }}">
            </li>
        @endforeach
    </ul>

    {{ $products->links('vendor.pagination.default') }}

@endsection
