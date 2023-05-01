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
                    <img src="{{ asset('storage/img/profile/profileImg1.jpg') }}" alt="Imagen de perfil">
                </div>
                <p>Nombre de Tienda</p>
            </div>
            <div class="shop-info-detail-seller">
                <div class="shop-info-detail-seller-img">
                    <img src="{{ asset('storage/img/profile/profileImg1.jpg') }}"
                        onerror="this.src='{{ asset('storage/img/profile/defaultProfileImage.jpg') }}'"
                        alt="Imagen de perfil">
                </div>
                <p>Nombre Usuario</p>
            </div>
        </article>
        <article class="shop-description">
            <h4>Mensaje de la Tienda:</h4>
            <input type="checkbox" id="expanded" name="expanded">
            <p>Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda
                Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda
                Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda
                Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda
                Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda
                Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda
                Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda
                Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda Mensaje de la Tienda </p>
            {{-- <label for="expanded" role="button">Leer más</label> --}}
            <div class="shop-description-button">
                <label for="expanded" role="button" data-more="Leer más..." data-less="Leer menos..."></label>
            </div>
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
