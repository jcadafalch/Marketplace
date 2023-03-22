@extends('layouts.master')
@section('title', 'Carrito Compra')
@section('content')
    <section>
        <h1>Mi cesta</h1>
        <h5>6 artículos</h5>
    </section>
    @foreach ($producte as $key => $productec)
        {{/* dd($productec) */}}
        <article class="shoppingcart-main-article shoppingcart-main-article-boxshadowNormal">
            <img class="shoppingcart-main-article-productImage" src="{{ asset('/images/LogoFooter.png') }}" alt="">
            <h3 class="shoppingcart-main-article-productName">{{ $productec[$key]->name }}</h3>
            <p class="shoppingcart-main-article-productDescription">
                {{ $productec[$key]->description }}
            </p>
            <button class="shoppingcart-main-article-productDelete" title="Eliminar producto de la lista">
                <span class="material-symbols-outlined shoppingcart-main-article-productDelete-span">
                    delete
                </span>
            </button>
            <h3 class="shoppingcart-main-article-productPrice"> {{ $productec[$key]->price }} €</h3>
        </article>
    @endforeach
    <aside class="shoppingcart-aside">
        <h2>Resumen</h2>
        <p>Subtotal articulos</p>
        <p class="shoppingcart-aside-preusubtotal">223,50€</p>
        <hr>
        <p>Total (impuestos includidos)</p>
        <p class="shoppingcart-aside-preufinal">223,50€</p>
    </aside>

@endsection
