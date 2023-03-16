@extends('layouts.master')
@section('title', 'Carrito Compra')
@section('content')
    <div class="shoppingcart">
        <section class="shoppingcart-section">
            <h1>Mi cesta</h1>
            <h5>6 artículos</h5>
        </section>
        <main class="shoppingcart-main">
            <article class="shoppingcart-main-article">
                <img class="shoppingcart-main-article-productImage" src="{{ asset('/images/LogoFooter.png') }}" alt="">
                <h3 class="shoppingcart-main-article-productName">Nom producte</h3>
                <p class="shoppingcart-main-article-productDescription">
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                </p>
                <button class="shoppingcart-main-article-productDelete" title="Eliminar producto de la lista">
                    <span class="material-symbols-outlined">
                        delete
                    </span>
                </button>
                <h3 class="shoppingcart-main-article-productPrice">10,99 €</h3>
            </article>
            <article class="shoppingcart-main-article">
                <img class="shoppingcart-main-article-productImage" src="{{ asset('/images/LogoFooter.png') }}"
                    alt="">
                <h3 class="shoppingcart-main-article-productName">Nom producte</h3>
                <p class="shoppingcart-main-article-productDescription">
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                </p>
                <button class="shoppingcart-main-article-productDelete" title="Eliminar producto de la lista">
                    <span class="material-symbols-outlined">
                        delete
                    </span>
                </button>
                <h3 class="shoppingcart-main-article-productPrice">10,99 €</h3>
            </article>
            <article class="shoppingcart-main-article">
                <img class="shoppingcart-main-article-productImage" src="{{ asset('/images/LogoFooter.png') }}"
                    alt="">
                <h3 class="shoppingcart-main-article-productName">Nom producte</h3>
                <p class="shoppingcart-main-article-productDescription">
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                </p>
                <button class="shoppingcart-main-article-productDelete" title="Eliminar producto de la lista">
                    <span class="material-symbols-outlined">
                        delete
                    </span>
                </button>
                <h3 class="shoppingcart-main-article-productPrice">10,99 €</h3>
            </article>
            <article class="shoppingcart-main-article">
                <img class="shoppingcart-main-article-productImage" src="{{ asset('/images/LogoFooter.png') }}"
                    alt="">
                <h3 class="shoppingcart-main-article-productName">Nom producte</h3>
                <p class="shoppingcart-main-article-productDescription">
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                </p>
                <button class="shoppingcart-main-article-productDelete" title="Eliminar producto de la lista">
                    <span class="material-symbols-outlined">
                        delete
                    </span>
                </button>
                <h3 class="shoppingcart-main-article-productPrice">10,99 €</h3>
            </article>
            <article class="shoppingcart-main-article">
                <img class="shoppingcart-main-article-productImage" src="{{ asset('/images/LogoFooter.png') }}"
                    alt="">
                <h3 class="shoppingcart-main-article-productName">Nom producte</h3>
                <p class="shoppingcart-main-article-productDescription">
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                </p>
                <button class="shoppingcart-main-article-productDelete" title="Eliminar producto de la lista">
                    <span class="material-symbols-outlined">
                        delete
                    </span>
                </button>
                <h3 class="shoppingcart-main-article-productPrice">10,99 €</h3>
            </article>
            <article class="shoppingcart-main-article">
                <img class="shoppingcart-main-article-productImage" src="{{ asset('/images/LogoFooter.png') }}"
                    alt="">
                <h3 class="shoppingcart-main-article-productName">Nom producte</h3>
                <p class="shoppingcart-main-article-productDescription">
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                    descripció descripcio
                    descripcio descripció
                </p>
                <button class="shoppingcart-main-article-productDelete" title="Eliminar producto de la lista">
                    <span class="material-symbols-outlined">
                        delete
                    </span>
                </button>
                <h3 class="shoppingcart-main-article-productPrice">10,99 €</h3>
            </article>

        </main>

        <aside class="shoppingcart-aside">
            <h2>Resumen</h2>
            <div class="shoppingcart-aside-subtotalcontent">
                <p lass="shoppingcart-aside-subtotaltitle">Subtotal articulos</p>
                <p class="shoppingcart-aside-subtotalpreu">223,50€</p>
            </div>
            <hr>
            <div class="shoppingcart-aside-preufinalcontent">
                <p>Total (impuestos includidos)</p>
                <p class="shoppingcart-aside-preufinal">223,50€</p>
            </div>
            <button class="shoppingcart-aside-sendorder">
                Realizar pedido
            </button>
        </aside>
    </div>

@endsection
