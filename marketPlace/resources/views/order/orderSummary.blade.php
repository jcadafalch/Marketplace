@extends('layouts.master')
@section('title', 'Resumen pedido')
@section('content')
    <section class="order-section">
        <article class="order-title">
            <h1>Resumen del pedido</h1>
            {{-- <section>
            <h1>Resumen de tu pedido</h1>
            <h5>{{ count($producte) }} artículos</h5>
        </section> --}}
            <a href="{{ route('order.orderSummaryPdf', ['id' => $order->id]) }}">
                <span class="material-symbols-outlined">
                    download
                </span>
            </a>
        </article>
        <p>Pedido realizado el: {{ $orderDate }}</p>
        <div style="display: none">{{ $total = 0 }}</div>

        @foreach ($shops as $shop)
            @foreach ($producte as $key => $productec)
                @if ($shop->id == $productec->shop_id)
                    <article class="order-product" id="{{ $productec->id }}">
                        <a href="{{ route('product.show', ['id' => $productec->id]) }}">
                            @if ($productec->getMainImage() != null)
                                <img class="order-product-image"
                                    src="{{ env('API_URL_IMAGES') . $productec->getMainImage() }}" />
                            @else
                                <img class="order-product-image" src="{{ asset('/images/imagesNotFound.webp') }}" />
                            @endif
                        </a>
                        <div>
                            {{-- <a href="{{ route('product.show', ['id' => $productec->id]) }}"> --}}
                            <h3 class="order-product-name">{{ $productec->name }}</h3>
                            <i class="order-product-price">Tienda: {{ $shop->name }}</i>
                            {{-- </a> --}}
                            {{-- <p class="shoppingcart-main-article-productDescription">
                                {{ $productec->description }}
                            </p> --}}
                        </div>
                        <p class="order-product-price"> {{ round($productec->price / 100, 2) }} €</p>
                    </article>
                    <hr>
                @endforeach
                {{-- <button class="button-newShop">Aceptar pedido</button>
            <button class="button-newShop">Pago realizado</button>
            <button class="button-newShop">Pedido enviado</button>
            <button class="button-newShop">Pedido recibido</button> --}}


                <aside class="order-total">
                    <h4>Total: {{ round($producte->sum('price') / 100, 2) }}€</h4>
                </aside>
    </section>
@endsection
