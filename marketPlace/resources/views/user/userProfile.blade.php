@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
    <section class="profile">
        <article class="user-content">
            <div class="user-img">
                <div class="user-img-imagePreview">
                    <img src="{{ asset('storage/img/profile/' . Auth::user()->path) }}"
                        onerror="this.src='{{ asset('images/imagesNotFound.webp') }}'" alt="Imagen de perfil">
                </div>
            </div>
            <div class="user-info">
                <p class="user-name">{{ Auth::user()->name }}</p>

                <a href={{ route('user.profile') }}><button class="button-UserProfile">Modificar perfil</button></a>
                @if ($shop != null)
                    <a href={{ route('shop.show', ['shopName' => $shop->name]) }}><button class="button-UserProfile">Mi
                            tienda</button></a>
                    <a href={{ route('shop.edit') }}><button class="button-UserProfile">Editar mi tienda</button></a>
                @else
                    <a href={{ route('shop.createNewShop') }}><button class="button-UserProfile">Mi tienda</button></a>
                @endif
            </div>
        </article>
        <article class="user-order">
            <details class="user-order-history">
                <summary class="user-order-history-title">Pedidos realizados</summary>
                <ul class="user-order-history-list">
                    @foreach ($shops as $shop)
                        <a href="{{ route('order.show' /*, ['shopName' => $shop->name]*/) }}">
                            <li class="order-product" id="1">
                                <img class="order-product-image"
                                    src="{{ asset('storage/img/shopProfile/' . $shop->getLogo()->url) }}"
                                    onerror="this.src='{{ asset('/images/imagesNotFound.webp') }}'" alt="Logo de la tienda">
                                <div>
                                    <h3 class="order-product-name">{{ $shop->name }}</h3>
                                </div>
                                <div>
                                    <p class="order-product-price"> Fecha </p>
                                    <p class="order-product-price"> Entregado </p>
                                    <p class="order-product-price"> Total: € </p>
                                </div>
                            </li>
                        </a>
                        <hr>
                    @endforeach
                </ul>
            </details>
        </article>
        @if ($shop != null)
            <article class="user-order">
                <details class="user-order-history">
                    <summary class="user-order-history-title">Productos vendidos</summary>
                    <ul class="user-order-history-list">
                        @foreach ($shops as $shop)
                            <a href="{{ route('order.selled' /*, ['id' => ]*/) }}">
                                <li class="order-product" id="1">
                                    <img class="order-product-image"
                                        src="{{ asset('storage/img/shopProfile/' . $shop->getLogo()->url) }}"
                                        onerror="this.src='{{ asset('/images/imagesNotFound.webp') }}'"
                                        alt="Logo de la tienda">
                                    <div>
                                        <h3 class="order-product-name">{{ $shop->name }}</h3>
                                    </div>
                                    <div>
                                        <p class="order-product-price"> Fecha </p>
                                        <p class="order-product-price"> Entregado </p>
                                        <p class="order-product-price"> Total: € </p>
                                    </div>
                                </li>
                            </a>
                            <hr>
                        @endforeach
                    </ul>
                </details>
            </article>
        @endif
    </section>
@endsection
