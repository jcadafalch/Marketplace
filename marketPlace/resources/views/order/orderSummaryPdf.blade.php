<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet">


    <title>Resumen pedido pdf</title>
</head>

<style>
    .content--section {
        font-size: 1.6rem;
    }

    .order-section {
        padding: 3vh 20vw 3vh 20vw;
    }

    .order-title {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(18rem, 1fr));
    }

    .order-product {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(18rem, 1fr));
        align-items: center;
        margin: 2rem;
    }

    .order-product-image {
        width: 15rem;
        border-radius: 1.6rem;
    }

    .order-product-price {
        text-align: end;
    }

    .order-total {
        margin-top: 2rem;
        text-align: end;
    }
</style>



<body>
    <img src="{{ public_path('images/Logo.png') }}" alt="Logo" width="50px" height="50px">
    <main class="content--section" style="font-size: 16px;">
        <section class="order-section" style=" padding: 3vh 20vw 3vh 20vw;">
            <article class="order-title"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
                <h1>Resumen del pedido</h1>
            </article>
            <p>Pedido realizado el: {{ $orderDate }}</p>
            <div style="display: none">{{ $total = 0 }}</div>

            @foreach ($producte as $key => $productec)
                <article class="order-product" id="{{ $productec->id }}"
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); align-items: center; margin: 20px;">

                    @if ($productec->getMainImage() != null)
                        <img class="order-product-image" style="width: 50px; height: 50px; border-radius: 1.6rem;"
                            src="{{ $src }}" />
                    @else
                        <img class="order-product-image" style="width: 50px; height: 50px; border-radius: 1.6rem;"
                            src="{{ asset('/images/imagesNotFound.webp' . $productec->getMainImage()) }}" />
                    @endif
                    <div>
                        <h3 class="order-product-name">{{ $productec->name }}</h3>
                        <i class="order-product-price" style="text-align: end;">Tienda:
                            {{ $shops->firstWhere('id', $productec->shop_id)->name }}</i>
                    </div>
                    <p class="order-product-price" style="text-align: end;"> {{ round($productec->price / 100, 2) }} €
                    </p>
                </article>
                <hr>
            @endforeach

            <aside class="order-total" style="margin-top: 20px; text-align: end;">
                <h4>Total: {{ round($producte->sum('price') / 100, 2) }}€</h4>
            </aside>
        </section>

    </main>
</body>

</html>
