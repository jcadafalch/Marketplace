@extends('layouts.master')

@section('title', 'Show')

@section('content')

    <div class='landing'>
        <div>
            <ul class="products-section">
            <h3>Titulo</h3>
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
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

@endsection
