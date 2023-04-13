<header class="header">
    <div class="header-logoHeader">
        <a href="{{ route('home.index') }}"><img src="{{ asset('/images/logo.png') }}" alt="Logo" /></a>
    </div>

    <form class="header-buscador-form-container buscador" action="{{ route('home.searchProduct') }}" method="get">
        <select id="selectCategories" class="header-buscador-form-container-selectCategories" name="category">
            <option value="allCategories">All Categories</option>
            @foreach ($categories as $key => $category)
                @if ($category->id == session('category'))
                    <option value="{{ $category->id }}" selected="true">{{ $category->name }}</option>
                @else
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endif
            @endforeach
        </select>
        <input type="search" name="search" class="header-buscador-form-container-search"
            placeholder="Buscar en Craft Made" value="{{ session('search') }}" />
        <button class="header-buscador-form-container-button" type="submit">
            <span class="material-symbols-rounded" id="headerButtonSearch">search</span>
        </button>
    </form>

    <div class="header-cartAndProfile">
        <div class="header-cartAndProfile-displayIcon">
            <a href="{{ route('shoppingCart.index') }}">
                <p id="numberOfProducts">0</p>
                <span class="material-symbols-outlined header-cartAndProfile-displayIcon-shoppingCart">
                    shopping_cart
                </span>
            </a>
        </div>
        @guest
            <div class="header-cartAndProfile-login">
                <a href="{{ route('auth.login') }}">
                    <button>
                        Regístrate / Inicia Sesión
                    </button>
                </a>
            </div>
        @else
            <div class="header-cartAndProfile-displayIcon header-cartAndProfile-user">
                <a href="{{route('user.userProfile')}}">
                    <span class="material-symbols-outlined"> person </span>
                    <p>{{ Auth::user()->name }}</p>
                </a>
            </div>
        @endguest
    </div>
</header>
