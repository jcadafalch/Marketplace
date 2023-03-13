@extends('layouts.master')

@section('title', 'Show')

@section('content')

    <div class="produt-detailsPage">
        <img class="product-image" src="{{ asset('storage/img/' . $product->url) }}" />

        <p class="product-name">{{ $product->name }}</p>
        <p class="product-description">{{ $product->description }}</p>
        <p class="product-price">{{ $product->price }}</p>

        <input class="button-addToCart" type="button" value="Añadir" id="{{ $product->id }}">
    </div>

@endsection
