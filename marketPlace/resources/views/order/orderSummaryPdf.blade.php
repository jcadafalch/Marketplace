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
    @php
        $logo_url = public_path('images/Logo.png');
        $logo_base64 = base64_encode(file_get_contents($logo_url));
    @endphp
    <img src="data:image/png;base64,{{ $logo_base64 }}" alt="Logo de la tienda">
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
                    $imagen_url = Http::withoutVerifying()->get(env('API_URL_IMAGES') . $productec->updateMainImage()->url);
                    $imagen_base64 = base64_encode($imagen_url->body());
                @endphp
                <tr>
                    <td><img src="data:image/png;base64,{{ $imagen_base64 }}" alt=""></td>
                    <td>{{ $productec->name }}</td>
                    @php
                        $shop = $shops->firstWhere('id', $productec->shop_id);
                        if ($shop == null) {
                            $shop = 'Desconocido';
                        } else {
                            $shop = $shop->name;
                        }
                    @endphp
                    <td>{{ $shop }}</td>
                    <td>{{ round($productec->price / 100, 2) }} €</td>
                </tr>
            @endforeach
            <tr class="total">
                <td colspan="3">Total:</td>
                <td>{{ round($producte->sum('price') / 100, 2) }}€</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
