<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>@yield('title')</title>
</head>

<body>
    @include('partials.header')
    <main class="content--section">
        @yield('content')
        @if (session('status'))
            <article class="products-section">
                <p>{{ session('status') }} </p>
            </article>
        @endif
    </main>
    @include('partials.footer')
    <script src="{{ asset('js/DeleteFromCart.js') }}"></script>
    <script src="{{ asset('js/addToCart.js') }}"></script>
</body>

</html>
