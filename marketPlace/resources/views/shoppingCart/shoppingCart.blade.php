@extends('layouts.master')
@section('title', 'Carrito Compra')
@section('content')
    <section>
        <h1>Mi cesta</h1>
        <h5>6 artículos</h5>
    </section>
    @foreach ($producte as $key => $productec)
        <article class="shoppingcart-article">
            <img src="{{ asset('/images/LogoFooter.png') }}" alt="">
            <h3>{{ $productec[$key]->name }}</h3>

            <p>{{ $productec[$key]->description }}</p>
            <button>
                <span class="material-symbols-outlined">
                    delete
                </span>
            </button>
            <p class="shoppingcart-productprice">
                {{ $productec[$key]->price }} €
            </p>
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
