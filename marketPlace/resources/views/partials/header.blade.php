<header>
    <div class="logoHeader">
        <a href="{{ route('home.index') }}"><img src="{{ asset('/images/LogoFooter.png') }}" alt="Logo" /></a>
    </div>
    <form class="header-buscardor-form buscador" action="{{ route('home.index') }}" method="get">
        <select id="selectCategories" name="category">
            <option value="allCategories">All Categories</option>
            @foreach ($categories as $key => $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <input type="search" name="search" id="search" placeholder="Introduce el articulo que quieres buscar" />
        <button class="header-buscador-form-button" type="submit"><span class="material-symbols-rounded"
                id="headerButtonSearch">search</span></button>
    </form>
    <div class="cartAndProfile">
        <div class="displayIcon">
            <p id="numberOfProducts">0</p>

            <span class="material-symbols-outlined shoppingCart">
                shopping_cart
            </span>
        </div>
        @guest
            <div class="login">
                <button>
                    <a href="{{ route('auth.login') }}">Regístrate / Inicia Sesión</a>
                </button>
            </div>
        @else
            <div class="displayIcon user">
                <span class="material-symbols-outlined"> person </span>
                <p>username</p>
            </div>
        @endguest
    </div>
</header>
