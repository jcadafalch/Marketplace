@extends('layouts.master')

@section('title', 'Tu tienda')

@section('content')

    @if ($shop->getBanner() != null)
        <nav class="shop-banner">
            <img class="shop-banner-image" src="{{ asset('storage/img/shopProfileBanner/' . $shop->getBanner()->url) }}"
                onerror="this.src='{{ asset('/images/imagesNotFound.webp') }}'" alt="Banner de la tienda">
        </nav>
    @endif
    <section class="shop-body">
        @if (Session::has('error'))
            <div class="error error-message" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <article class="shop-info">
            <div class="shop-info-detail-shop">
                <div class="shop-info-detail-shop-img">
                    <img src="{{ asset('storage/img/shopProfile/' . $shop->getLogo()->url) }}"
                        onerror="this.src='{{ asset('/images/imagesNotFound.webp') }}'" alt="Logo de la tienda">
                </div>
                <p> {{ $shop->name }} </p>
            </div>
            <div class="shop-info-detail-seller">
                <div class="shop-info-detail-seller-img">
                    <img src="{{ asset('storage/img/profile/' . strval($shop->getOwner()->path)) }}"
                        onerror="this.src='{{ asset('/images/imagesNotFound.webp') }}'" alt="Imagen de perfil del vendedor">
                </div>
                <p>{{ $shop->ownerName }}</p>
            </div>
        </article>
        @if ($shop->description != null)
            <article class="shop-description">
                <h4>Mensaje de la Tienda:</h4>
                <p> {{ $shop->description }} </p>
            </article>
        @endif
        <article class="shop-products">
            <h4>Todos los productos</h4>

            <ul class="products-section">
                @foreach ($productsShop as $key => $product)
                    <li class="product" id="{{ $product->id }}">
                        <div class="product-image">
                            <a href="{{ route('product.show', ['id' => $product->id]) }}">
                                @if ($product->getMainImage() != null)
                                    <img src="{{ asset('storage/img/' . $product->getMainImage()) }}"
                                        alt="Imagen del producto" />
                                @else
                                    <img src="{{ asset('/images/imagesNotFound.webp' . $product->getMainImage()) }}"
                                        alt="Imagen del producto" />
                                @endif
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
        {{ $productsShop->links('vendor.pagination.default') }}
    </section>
@endsection
