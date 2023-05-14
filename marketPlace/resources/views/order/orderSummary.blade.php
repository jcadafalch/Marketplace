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
            <span class="material-symbols-outlined">
                download
            </span>
        </article>
        <p>Pedido realizado el: {{ $orderDate }}</p>
        <div style="display: none">{{ $total = 0 }}</div>

        @foreach ($producte as $key => $productec)
            <article class="order-product" id="{{ $productec->id }}">
                <a href="{{ route('product.show', ['id' => $productec->id]) }}">
                    @if ($productec->getMainImage() != null)
                        <img class="order-product-image" src="{{ asset('storage/img/' . $productec->getMainImage()) }}" />
                    @else
                        <img class="order-product-image"
                            src="{{ asset('/images/imagesNotFound.webp' . $productec->getMainImage()) }}" />
                    @endif
                </a>
                <div>
                    {{-- <a href="{{ route('product.show', ['id' => $productec->id]) }}"> --}}
                    <h3 class="order-product-name">{{ $productec->name }}</h3>
                    <i class="order-product-price">Tienda: {{ $shops->firstWhere('id', $productec->shop_id)->name }}</i>
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
