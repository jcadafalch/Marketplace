@extends('layouts.master')

@section('title', 'Home')

@section('content')

    <h1> Home Page </h1>
    <div class="products-section">
        @foreach ($products as $key => $product)
            <div class="product">
                <a href="{{ route('product.show', ['id' => $product->id]) }}">
                    <img src="{{ asset('storage/img/' . $product->url)}}" style="height:200px" />
                    <h4>
                        {{ $product->name }}
                    </h4>
                </a>
                <input type="button" value="Añadir a carrito">
            </div>
        @endforeach
        </div>
            <script>
            </script>
@endsection
