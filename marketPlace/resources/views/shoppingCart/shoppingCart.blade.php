@extends('layouts.master')
@section('title', 'Carrito Compra')
@section('content')
    <section class="shoppingCart-section">
        <section>
            <h1>Mi cesta</h1>
            <h5>{{ count($producte) }} artículos</h5>
        </section>
        <div style="display: none">{{ $total = 0 }}</div>
        @if ($producte == [])
            <article>
                <h2>No hay productos en el carrito</h2>
            </article>
        @else
            @foreach ($producte as $key => $productec)
                <div style="display: none"> {{ $total += round($productec->price/100, 2) }}</div>
                <article class="shoppingcart-main-article shoppingcart-main-article-boxshadowNormal"
                    id="{{ $productec->id }}">
                    <a href="{{ route('product.show', ['id' => $productec->id]) }}">
                        @if ($productec->getMainImage() != null)
                            <img class="shoppingcart-main-article-productImage"
                                src="{{ env('API_URL_IMAGES') . $productec->getMainImage() }}" />
                        @else
                            <img class="shoppingcart-main-article-productImage"
                                src="{{ asset('/images/imagesNotFound.webp') }}" />
                        @endif
                    </a>
                    <div>
                        <a href="{{ route('product.show', ['id' => $productec->id]) }}">
                            <h3 class="shoppingcart-main-article-productName">{{ $productec->name }}</h3>
                        </a>
                        <p class="shoppingcart-main-article-productDescription">
                            {{ $productec->description }}
                        </p>
                    </div>
                    <button class="shoppingcart-main-article-productDelete" title="Eliminar producto de la lista">
                        <span class="material-symbols-outlined shoppingcart-main-article-productDelete-span">
                            delete
                        </span>
                    </button>
                    <h3 class="shoppingcart-main-article-productPrice"> {{ round($productec->price/100, 2) }} €</h3>
                </article>
            @endforeach
        @endif
        <aside class="shoppingcart-aside">
            <h2>Resumen</h2>
            <p>Total (impuestos includidos)</p>
            <p class="shoppingcart-aside-preufinal">{{ $total }}€</p>
            <hr>
            <ul class="userForm-form-error">
                @foreach ($errors as $error)
                    <li>{{!! $error !!}}</li>
                @endforeach
            </ul>
            <a class="button-newShop" href={{ route('shoppingCart.confirmOrder') }}>
                Realizar pedido
                {{-- <button class="button-newShop">Realizar pedido</button> --}}
            </a>
        </aside>
    </section>
@endsection
