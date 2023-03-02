<!doctype html>
<html lang="en"> 

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('css.css') }}"> 

    <title>@yield('title')</title> 
</head>

<body>
    {{-- @include('partials.navbar')  --}}
    <div>
        @yield('content') 
    </div>

</body>

</html>