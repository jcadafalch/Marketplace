@extends('layouts.master')
@section('title', 'Carrito Compra')
@section('content')
<section class="shoppingCart-section">
    <section>
        <h1>Mi cesta</h1>
        <h5>{{count($producte)}} artículos</h5>
    </section>
    <div style="display: none">{{$total = 0}}</div>
    @if ($producte == [])
        <article>
            <h2>No hay productos en el carrito</h2>
        </article>
    @else
    @foreach ($producte as $key => $productec)
    <div style="display: none"> {{$total += $productec->price}}</div>
        <article class="shoppingcart-main-article shoppingcart-main-article-boxshadowNormal" id="{{$productec->id}}">
            <img class="shoppingcart-main-article-productImage" src="{{  asset('storage/img/' . $productec->url) }}" alt="">
            <h3 class="shoppingcart-main-article-productName">{{ $productec->name }}</h3>
            <p class="shoppingcart-main-article-productDescription">
                {{ $productec->description }}
            </p>
            <button class="shoppingcart-main-article-productDelete" title="Eliminar producto de la lista">
                <span class="material-symbols-outlined shoppingcart-main-article-productDelete-span">
                    delete
                </span>
            </button>
            <h3 class="shoppingcart-main-article-productPrice"> {{ $productec->price }} €</h3>
        </article>
    @endforeach
    @endif
    <aside class="shoppingcart-aside">
        <h2>Resumen</h2>
        <p>Subtotal articulos</p>
        <p class="shoppingcart-aside-preusubtotal">{{$total}}€</p>
        <hr>
        <p>Total (impuestos includidos)</p>
        <p class="shoppingcart-aside-preufinal">{{$total}}€</p>
        <button class="button-addToCart">Realizar pedido</button>
    </aside>
</section>
@endsection
