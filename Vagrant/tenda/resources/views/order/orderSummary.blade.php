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

        @foreach ($producte as $key => $productec)
            <article class="order-product" id="{{ $productec->id }}">
                <a href="{{ route('product.show', ['id' => $productec->id]) }}">
                    @if ($productec->getMainImage() != null)
                        <img class="order-product-image" src="{{ env('API_URL_IMAGES') . $productec->getMainImage() }}" alt="Imagen de producto"/>
                    @else
                        <img class="order-product-image"
                            src="{{ asset('/images/imagesNotFound.webp') }}" alt="Imagen no encontrada" />
                    @endif
                </a>
                <div>
                    <h3 class="order-product-name">{{ $productec->name }}</h3>
                    @php
                        $shop = $shops->firstWhere('id', $productec->shop_id);
                        if ($shop == null) {
                            $shop = 'Desconocido';
                        } else {
                            $shop = $shop->name;
                        }
                    @endphp
                    <i class="order-product-price">Tienda: {{ $shop }}</i>
                </div>
                <p class="order-product-price"> {{ round($productec->price / 100, 2) }} €</p>
            </article>
            <hr>
        @endforeach

        <aside class="order-total">
            <h4>Total: {{ round($producte->sum('price') / 100, 2) }}€</h4>
        </aside>
    </section>
@endsection
