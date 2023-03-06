@extends('layouts.master')

@section('title', 'Home')

@section('content')

    <h1> Home Page </h1>
    <div class="products-section">
        @foreach ($products as $key => $product)
            <div class="product">
                <img src="{{ $product->url }}" style="height:200px" />
                <h4>
                    {{ $product->name }}
                </h4>

            </div>
        @endforeach
    </div>

@endsection
