@extends('layouts.master')

@section('title', 'Home')

@section('content')

    <h1> Home Page </h1>
    <div class="products-section">
        @foreach ($products as $key => $product)
            <div class="product">
                <a href="{{ route('product.show', ['id' => $product->id]) }}">

                    <img src="{{ asset('storage/img/' . $product->url) }}" />

                    <h4>
                        {{ $product->name }}
                    </h4>
                </a>

                <p> {{ $product->price }}€ </p>
                <input type="button" value="Añadir">
            </div>
        @endforeach
    </div>
    <script></script>
@endsection
