@extends('layouts.master')
@section('title', 'Resumen pedido')
@section('content')
    <section class="order-section">
        <article class="order-title">
            <h1>Resumen del pedido</h1>
            <a href="{{ route('order.orderLineSummaryPdf', ['id' => $orderLine->id]) }}">
                <span class="material-symbols-outlined">
                    download
                </span>
            </a>

        </article>
        <p>Pedido realizado el: {{ $orderDate }}</p>
        <p>Número de pedido: {{ $order->id }}</p>
        <p>Número de linea de pedido: {{ $orderLine->id }}</p>
        @foreach ($producte as $key => $productec)
            <article class="order-product" id="{{ $productec->id }}">
                <a href="{{ route('product.show', ['id' => $productec->id]) }}">
                    @if ($productec->getMainImage() != null)
                        <img class="order-product-image" src="{{ env('API_URL_IMAGES') . $productec->getMainImage() }}" />
                    @else
                        <img class="order-product-image" src="{{ asset('/images/imagesNotFound.webp') }}" />
                    @endif
                </a>
                <div>
                    <a href="{{ route('product.show', ['id' => $productec->id]) }}">
                        <h3 class="order-product-name">{{ $productec->name }}</h3>
                    </a>
                </div>
                <p class="order-product-price"> {{ round($productec->price / 100, 2) }} €</p>
            </article>
            <hr>
        @endforeach
    @endsection
