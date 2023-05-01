@extends('layouts.master')

@section('title', 'Crear tienda')

@section('content')

    <nav class="shop-banner">
        <img src="{{ asset('storage/img/banner.jpg') }}" alt="">
    </nav>
    <section class="shop-body">
        <article class="shop-info">
            <div class="shop-info-detail-shop">
                <div class="shop-info-detail-shop-img">
                    <img src="{{ asset('storage/img/profile/' . Auth::user()->path) }}" alt="Imagen de perfil">
                </div>
                <p>Nombre de Tienda</p>
            </div>
            <div class="shop-info-detail-seller">
                <div class="shop-info-detail-seller-img">
                    <img src="{{ asset('storage/img/profile/' . Auth::user()->path) }}"
                        onerror="this.src='{{ asset('storage/img/profile/defaultProfileImage.jpg') }}'"
                        alt="Imagen de perfil">
                </div>
                <p>Nombre Usuario</p>
            </div>
        </article>
        <article class="shop-description">
            <h4>Mensaje de la Tienda:</h4>
            <p>Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda
                Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda </p>
        </article>
        <article class="shop-products">
            <h4>Todos los productos</h4>

            <ul class="products-section">
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
                                <p class="product-price"> {{ $product->price }}€ </p>
                            </a>
                        </div>
        
                        <input class="button-addToCart" type="button" value="Añadir" id="{{ $product->id }}">
                    </li>
                @endforeach
            </ul>
        </article>
    </section>
@endsection
