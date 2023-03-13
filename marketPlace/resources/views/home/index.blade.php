@extends('layouts.master')

@section('title', 'Home')

@section('content')

    <h1> Todos los productos </h1>
    <ul class="products-section">
        @foreach ($products as $key => $product)
            <li class="product">
                <div class="product-image">
                    <a href="{{ route('product.show', ['id' => $product->id]) }}">
                        <img src="{{ asset('storage/img/' . $product->url) }}" />
                    </a>
                </div>
                <div class="product-details">
                    <a href="{{ route('product.show', ['id' => $product->id]) }}">
                        <p class="product-name"> {{ $product->name }} </p>
                    </a>
                    <p class="product-price"> {{ $product->price }}€ </p>
                </div>

                <input class="button-addToCart" type="button" value="Añadir" id="{{ $product->id }}">
            </li>
        @endforeach
    </ul>

    {{ $products->links() }}
    
@endsection
