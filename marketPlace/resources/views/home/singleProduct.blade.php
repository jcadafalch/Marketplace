@extends('layouts.master')

@section('title', 'Show')

@section('content')
    <h3 class="product-name">{{ $product->name }}</h3>
    <div class="product-detailsPage" id="{{ $product->id }}">
        <div class="product-images">
            <div>
                <img class="product-images-main" src="{{ asset('storage/img/' . $product->url) }}" />
            </div>
            <div>
                <img class="product-images-sec" src="{{ asset('storage/img/' . $product->url) }}" />
                <img class="product-images-sec" src="{{ asset('storage/img/' . $product->url) }}" />
                <img class="product-images-sec" src="{{ asset('storage/img/' . $product->url) }}" />
            </div>
        </div>
        <div class="product-details">
            <p class="product-price">{{ $product->price }} €</p>
            <p class="product-name">{{ $product->name }}</p>
            <p class="product-description">{{ $product->description }}</p>
            <p>
                Tienda:
                <a class="product-storeName" href="{{ route('home.index') }}" target="_blank"> <em>{{$shop[0]->shop_name}}</em> </a>
            </p>
            <input class="button-addToCart" type="button" value="Añadir" id="{{ $product->id }}">
        </div>
    </div>
@endsection
