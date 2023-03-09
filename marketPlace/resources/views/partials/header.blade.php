<header>
    <div class="logoHeader">
        <img src="{{ asset('/images/LogoFooter.png') }}" alt="Logo" />
    </div>

    <div class="buscador">
        <select id="selectCategories">
            <option value="">Todas las categorías</option>
            <option value="">Todas las categorías</option>
            <option value="">Todas las categorías</option>
        </select>
        <input type="search" name="" id="search" placeholder="Introduce el articulo que quieres buscar" />
        <span class="material-symbols-rounded" id="headerButtonSearch">
            search
        </span>
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
                <a href="{{ redirect('/login') }}">Regístrate / Inicia Sesión</a>
            </button>
        </div>
    </div>
</header>
