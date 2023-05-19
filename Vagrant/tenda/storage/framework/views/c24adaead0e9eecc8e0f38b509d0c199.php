<?php $__env->startSection('title', 'Tu tienda'); ?>

<?php $__env->startSection('content'); ?>
    
    <?php if($shop->getBanner() != null): ?>
        <nav class="shop-banner">
            <img class="shop-banner-image" src="<?php echo e(asset('storage/img/shopProfileBanner/' . $shop->getBanner()->url)); ?>"
                onerror="this.src='<?php echo e(asset('/images/imagesNotFound.webp')); ?>'" alt="Banner de la tienda">
        </nav>
    <?php endif; ?>
    <section class="shop-body">
        <?php if(Session::has('error')): ?>
            <div class="error error-message" role="alert">
                <?php echo e(Session::get('error')); ?>

            </div>
        <?php endif; ?>
        <article class="shop-info">
            <div class="shop-info-detail-shop">
                <div class="shop-info-detail-shop-img">
                    <img src="<?php echo e(asset('storage/img/shopProfile/' . $shop->getLogo()->url)); ?>"
                        onerror="this.src='<?php echo e(asset('/images/imagesNotFound.webp')); ?>'" alt="Logo de la tienda">
                </div>
                <p> <?php echo e($shop->name); ?> </p>
            </div>
            <div class="shop-info-detail-seller">
                <div class="shop-info-detail-seller-img">
                    <img src="<?php echo e(asset('storage/img/profile/' . strval($shop->getOwner()->path))); ?>"
                        onerror="this.src='<?php echo e(asset('/images/imagesNotFound.webp')); ?>'" alt="Imagen de perfil del vendedor">
                </div>
                <p><?php echo e($shop->ownerName); ?></p>
            </div>
        </article>
        <?php if($shop->description != null): ?>
            <article class="shop-description">
                <h4>Mensaje de la Tienda:</h4>
                <p> <?php echo e($shop->description); ?> </p>
            </article>
        <?php endif; ?>
        <article class="shop-products">
            <h4>Todos los productos</h4>

            <ul class="products-section">
                <?php $__currentLoopData = $productsShop; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="product" id="<?php echo e($product->id); ?>">
                        <div class="product-image">
                            <a href="<?php echo e(route('product.show', ['id' => $product->id])); ?>">
                                <?php if($product->getMainImage() != null): ?>
                                    <img src="<?php echo e(env('API_URL_IMAGES') . $product->getMainImage()); ?>"
                                        alt="Imagen del producto" />
                                <?php else: ?>
                                    <img src="<?php echo e(asset('/images/imagesNotFound.webp')); ?>"
                                        alt="Imagen del producto" />
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="product-details">
                            <a href="<?php echo e(route('product.show', ['id' => $product->id])); ?>">
                                <p class="product-name"> <?php echo e($product->name); ?> </p>
                                <p class="product-price"> <?php echo e($product->price); ?>€ </p>
                            </a>
                        </div>

                        <input class="button-addToCart" type="button" value="Añadir" id="<?php echo e($product->id); ?>">
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </article>
        <?php echo e($productsShop->links('vendor.pagination.default')); ?>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/shop/index.blade.php ENDPATH**/ ?>