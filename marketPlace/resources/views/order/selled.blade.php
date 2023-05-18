@extends('layouts.master')
@section('title', 'Resumen pedido')
@section('content')
    <section class="order-section">
        <article class="order-title">
            <h1>Resumen del pedido</h1>
            <a href="{{ route('order.selledPdf', ['id' => $orderLine->id]) }}">
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
                        <img class="order-product-image" src="{{ asset($productec->getMainImage()) }}" alt="Imagen de producto" />
                    @else
                        <img class="order-product-image" src="{{ asset('/images/imagesNotFound.webp') }}" alt="Imagen no encontrada"/>
                    @endif
                </a>
                <div>
                    <a href="{{ route('product.show', ['id' => $productec->id]) }}">
                        <h3 class="order-product-name">{{ $productec->name }}</h3>
                        {{-- <i class="order-product-price">Tienda: {{ $shop->name }}</i> --}}
                    </a>
                </div>
                <p class="order-product-price"> {{ round($productec->price / 100, 2) }} €</p>
            </article>
            <hr>
        @endforeach

        <aside class="order-total">
            <h4>Total: {{ round($producte->sum('price') / 100, 2) }}€</h4>
        </aside>
        {{-- <button class="button-newShop">Aceptar pedido</button> --}}
        <button class="button-newShop paid" id="{{ $orderLine->id }}" @if ($orderLine->pendingToPay == 0) disabled @endif>
            Pago realizado
        </button>
        <button class="button-newShop sent" id="{{ $orderLine->id }}" @if ($orderLine->send_at != null || $orderLine->pendingToPay == 1) disabled @endif>
            Pedido enviado
        </button>
    </section>

    <script src="{{ asset('js/orderSelled.js') }}"></script>
@endsection
