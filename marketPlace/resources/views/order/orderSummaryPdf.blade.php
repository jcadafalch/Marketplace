<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet">


    <title>Resumen pedido {{ $order->id }}</title>

    <style>
        .pedido-info {
            display: flex;
            justify-content: space-between;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f5a166;
            color: black;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) img {
            border: solid white 2px;
        }

        tr:nth-child(odd) img {
            border: solid whitesmoke 2px;
        }

        img {

            border-radius: 10%;
            display: block;
            margin: auto;
            width: 150px;
            height: 112px;
            object-fit: contain;
        }

        .total {
            font-weight: bold;
            background: #f5a166 !important;
        }
    </style>
</head>




<body>
    <img src={{ public_path('images/Logo.png') }} alt="Logo de la tienda">
    <h1>Detalle de Pedido</h1>
    <div style="margin-bottom: 50px;">
        <span style="float: left;">Número de pedido: {{ $order->id }}</span>
        <span style="float: right;">Fecha del pedido: {{ $orderDate }}</span>
    </div>
    <table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Tienda</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($producte as $productec)
                @php
                    $imagen_url = $productec->updateMainImage()->url;
                    $imagen_base64 = base64_encode(file_get_contents($imagen_url));
                @endphp
                <tr>
                    <td><img src="data:image/png;base64,{{ $imagen_base64 }}"></td>
                    <td>{{ $productec->name }}</td>
                    <td>{{ $shops->firstWhere('id', $productec->shop_id)->name }}</td>
                    <td>{{ round($productec->price / 100, 2) }} €</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3">Total:</td>
                <td>{{ round($producte->sum('price') / 100, 2) }}€</td>
            </tr>
        </tbody>
    </table>
    {{-- <img src="{{ public_path('images/Logo.png') }}" alt="Logo" width="50px" height="50px">
    <main class="content--section" style="font-size: 16px; with: 1000px;">
        <section class="order-section" style="float: left; with: 1000px; padding: 3vh 20vw 3vh 20vw;">
            <article class="order-title"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
                <h1>Resumen del pedido</h1>
            </article>
            <p>Pedido realizado el: {{ $orderDate }}</p>
            <div style="display: none">{{ $total = 0 }}</div>

            @foreach ($producte as $key => $producte)
                <article class="order-product" id="{{ $productec->id }}"
                    style=" with: 1000px; align-items: center; margin: 20px;">

                    @php
                        $imagen_url = $productec->updateMainImage()->url;
                        $imagen_base64 = base64_encode(file_get_contents($imagen_url));
                    @endphp

                    @if ($productec->getMainImage() != null)
                        <img class="order-product-image" style="width: 150px; height: 112px; border-radius: 1.6rem;"
                            src="data:image/png;base64,{{ $imagen_base64 }}" />
                    @else
                        <img class="order-product-image" style="width: 50px; height: 50px; border-radius: 1.6rem;"
                            src="{{ asset('/images/imagesNotFound.webp' . $productec->getMainImage()) }}" />
                    @endif
                    <div style="float:right; margin-left: 200px;">
                        <h3 class="order-product-name">{{ $productec->name }}</h3>
                        <i class="order-product-price" style="text-align: end;">Tienda:
                            {{ $shops->firstWhere('id', $productec->shop_id)->name }}</i>
                    </div>
                    <p class="order-product-price"
                        style="float:right; margin-left:400px; margin-top: 50px; text-align: end;">
                        {{ round($productec->price / 100, 2) }} €
                    </p>
                </article>
                <hr width="100%">
            @endforeach

            <aside class="order-total" style=" margin-left: 100px; margin-top: 20px; text-align: end;">
                <h4>Total: {{ round($producte->sum('price') / 100, 2) }}€</h4>
            </aside>
        </section>

    </main> --}}
</body>

</html>
