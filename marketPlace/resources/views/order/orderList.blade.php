@extends('layouts.master')
@section('title', 'Resumen pedido')
@section('content')
    <section class="profile">
        <h2>Pedidos realizados</h2>
        <article class="user-order">
            <details class="user-order-history">
                <summary class="user-order-history-title">Numero de pedido: 1</summary>
                <div class="user-order-history-download">
                    <a href="{{ route('order.selledList') }}">
                        <h3>Visualizar pedido</h3>
                    </a>
                    <a href="{{ route('order.selledList') }}">
                        <span class="material-symbols-outlined">
                            download
                        </span>
                    </a>
                </div>
                <ul class="user-order-history-list">
                    @foreach ($shops as $shop)
                        <li class="order-product" id="1">
                            <a href="{{ route('order.show' /*, ['shopName' => $shop->name]*/) }}">
                                <p>Logo tienda</p>
                                <img class="order-product-image"
                                    src="{{ asset('storage/img/shopProfile/' . $shop->getLogo()->url) }}"
                                    onerror="this.src='{{ asset('/images/imagesNotFound.webp') }}'" alt="Logo de la tienda">
                            </a>
                            <div>
                                <a href="{{ route('order.show' /*, ['shopName' => $shop->name]*/) }}">
                                    <h3 class="order-product-name">{{ $shop->name }}</h3>
                                    <p class="order-product-list"> Producto 1, Producto 2, Producto 3, Producto 4 </p>
                                </a>
                            </div>

                            <div class="order-product-price">
                                <p> Fecha </p>
                                <p> Entregado </p>
                                <p> Total: € </p>
                                <a href="{{ route('order.show' /*, ['shopName' => $shop->name]*/) }}">
                                    <span class="material-symbols-outlined order-product-price">
                                        download
                                    </span>
                                </a>
                            </div>
                        </li>

                        <hr>
                    @endforeach
                </ul>
            </details>
        </article>
    </section>
@endsection
