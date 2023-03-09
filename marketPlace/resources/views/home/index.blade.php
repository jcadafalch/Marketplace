@extends('layouts.master')

@section('title', 'Home')

@section('content')

    <h1> Home Page </h1>
    <div class="products-section">
        @foreach ($products as $key => $product)
            <a href="{{ route('product.show', ['id' => $product->id]) }}">
                <div class="product">
                    <img src="{{ $product->url }}" style="height:200px" />
                    <h4>
                        {{ $product->name }}
                    </h4>

                </div>
            </a>
        @endforeach
    </div>

@endsection
