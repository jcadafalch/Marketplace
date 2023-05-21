<?php $__env->startSection('title', 'Show'); ?>

<?php $__env->startSection('content'); ?>
    <section class="product-detailsPage" id="<?php echo e($product->id); ?>">
        <article>
            <div class="slider">
                <div class="slide_viewer">
                    <div class="slide_group">
                        <div class="slide">
                            <?php if($product->getMainImage() != null): ?>
                                <img class="product-images-img"
                                    src="<?php echo e(env('API_URL_IMAGES') . $product->getMainImage()); ?>" alt="Imagen principal de producto" />
                            <?php else: ?>
                                <img class="product-images-img"
                                    src="<?php echo e(asset('/images/imagesNotFound.webp')); ?>" alt="Imagen no encontrada" />
                            <?php endif; ?>
                        </div>
                        <?php $__currentLoopData = $product->getAlternativeImages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $imgUrl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="slide">
                                <img class="product-images-img" src="<?php echo e(env('API_URL_IMAGES') . $imgUrl); ?>" alt="Imagen de producto"/>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="slide_buttons">
            </div>
        </article>

        <article class="product-details">
            <h3 class="product-name"><?php echo e($product->name); ?></h3>
            <p class="product-price"><?php echo e(round($product->price/100, 2)); ?> €</p>
            <p class="product-description"><?php echo e($product->description); ?></p>
            <p>
                Tienda:
                <a class="product-storeName" href="<?php echo e(route('shop.show', ['shopName' => $shop[0]->name])); ?>"
                    target="_blank">
                    <em><?php echo e($shop[0]->name); ?></em> </a>
            </p>
            <input class="button-addToCart" type="button" value="Añadir" width="100%" id="<?php echo e($product->id); ?>">
        </article>
    </section>

    <script src="<?php echo e(asset('js/slider.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\prj\DAW\marketplace_github\Marketplace\marketPlace\resources\views/home/singleProduct.blade.php ENDPATH**/ ?>