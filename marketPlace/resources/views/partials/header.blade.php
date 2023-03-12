<header>
    <div class="logoHeader">
         <a href="{{ route('home.index') }}"><img src="{{ asset('/images/LogoFooter.png') }}" alt="Logo" /></a> 
    </div>

    <div class="buscador">
        <form  class="header-buscardor-form" action="" method="post">
         @csrf
           <select id="selectCategories" name="category">
            <option value="allCategories">All Categories</option>
            @foreach ($categories as $key => $category)
            <option value="{{ $category->name }}">{{ $category->name }}</option>
            @endforeach
            </select>
            <input type="search" name="search" id="search" placeholder="Introduce el articulo que quieres buscar" />
            <button class="header-buscador-form-button" type="submit" ><span class="material-symbols-rounded" id="headerButtonSearch">search</span></button>
        </form>
    </div>

    <div class="cartAndProfile">
        <div class="displayIcon">
            <p id="numberOfProducts">0</p>
            <span class="material-symbols-outlined shoppingCart">
                shopping_cart
            </span>
        </div>

        <div class="displayIcon user" style="display: none">
            <span class="material-symbols-outlined"> person </span>
            <p>username</p>
        </div>
        <div class="login">
            <button>
                <a href="{{ route('auth.login') }}">Regístrate / Inicia Sesión</a>
            </button>
        </div>
    </div>
</header>
