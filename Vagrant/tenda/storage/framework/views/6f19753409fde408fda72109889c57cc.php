<header class="header">
    <div class="header-logoHeader">
        <a href="<?php echo e(route('landingPage')); ?>"><img src="<?php echo e(asset('/images/logo.png')); ?>" alt="Logo" /></a>
    </div>

    <form class="header-buscador-form-container buscador" action="<?php echo e(route('home.searchProduct')); ?>" method="get">
        <select id="selectCategories" class="header-buscador-form-container-selectCategories" name="category">
            <option value="allCategories">Categorias</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($category->id == session('category')): ?>
                    <option value="<?php echo e($category->id); ?>" selected="true"><?php echo e($category->name); ?></option>
                <?php else: ?>
                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <input type="search" name="search" class="header-buscador-form-container-search" placeholder="¿Que buscas?"
            value="<?php echo e(session('search')); ?>" />
        <button class="header-buscador-form-container-button" type="submit">
            <span class="material-symbols-rounded" id="headerButtonSearch">search</span>
        </button>
    </form>

    <div class="header-cartAndProfile">
        <div class="header-cartAndProfile-displayIcon">
            <a href="<?php echo e(route('shoppingCart.index')); ?>">
                <p id="numberOfProducts">0</p>
                <span class="material-symbols-outlined header-cartAndProfile-displayIcon-shoppingCart">
                    shopping_cart
                </span>
            </a>
        </div>
        <?php if(auth()->guard()->guest()): ?>
            <div class="header-cartAndProfile-login">
                <a href="<?php echo e(route('auth.login')); ?>">
                    <button>
                        Identificate
                    </button>
                </a>
            </div>
        <?php else: ?>
            <div class="header-cartAndProfile-displayIcon header-cartAndProfile-user">
                <a href="<?php echo e(route('user.userProfile')); ?>">
                    <span class="material-symbols-outlined"> person </span>
                    <p><?php echo e(Auth::user()->name); ?></p>
                </a>
            </div>
            <div class="header-cartAndProfile-login">
                <a href="<?php echo e(route('auth.logout')); ?>">
                    <span class="material-symbols-outlined">
                        logout
                    </span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</header>
<?php /**PATH /var/www/html/resources/views/partials/header.blade.php ENDPATH**/ ?>