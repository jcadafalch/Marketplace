<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>@yield('title')</title>
</head>

<body>
@include('partials.header')
    <div class="error"> 
        <div class="error-image"><img src="{{ asset('/images/Error.png') }}" alt="Logo"/></div>
        <div class="error-message">
            @yield('content')
        </div>
         <a href="{{ route('home.index') }}"><button class="button-error">Página de inicio</button></a>
    </div>
@include('partials.footer')
</body>

</html>