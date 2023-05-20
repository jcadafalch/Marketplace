<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>
    <section class="home-section">
        <article class="home-section-title">
            <h1> Todos los productos </h1>
            <?php if(!Route::is('landingPage.showAll')): ?>
                <form id="form-order" action="<?php echo e(route('home.searchProduct')); ?>" method="get">
                    <input type="hidden" name="category" id="category" />
                    <input type="hidden" name="search" id="search" />
                    <select name="order" id="order">
                        <option value="" disabled selected hiden>Ordenar por</option>
                        <option value="ASC">A-Z</option>
                        <option value="DESC">Z-A</option>
                    </select>
                </form>
            <?php endif; ?>
        </article>
        <ul class="products-section">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="product" id="<?php echo e($product->id); ?>">
                    <div class="product-image">
                        <a href="<?php echo e(route('product.show', ['id' => $product->id])); ?>">
                            <?php if($product->getMainImage() != null): ?>
                                <img src="<?php echo e(env('API_URL_IMAGES') . $product->getMainImage()); ?>" alt="Imagen de producto" />
                            <?php else: ?>
                                <img src="<?php echo e(asset('/images/imagesNotFound.webp')); ?>" alt="Imagen no encontrada"/>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="product-details">
                        <a href="<?php echo e(route('product.show', ['id' => $product->id])); ?>">
                            <p class="product-name"> <?php echo e($product->name); ?> </p>
                            <p class="product-price"> <?php echo e(round($product->price / 100, 2)); ?>€ </p>
                        </a>
                    </div>
                    <input class="button-addToCart" type="button" value="Añadir" id="<?php echo e($product->id); ?>">
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <?php echo e($products->links('vendor.pagination.default')); ?>

    </section>
    <script src="<?php echo e(asset('js/orderBy.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/home/index.blade.php ENDPATH**/ ?>