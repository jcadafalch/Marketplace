<?php $__env->startSection('title', 'Carrito Compra'); ?>
<?php $__env->startSection('content'); ?>
    <section class="shoppingCart-section">
        <section>
            <h1>Mi cesta</h1>
            <h5><?php echo e(count($producte)); ?> artículos</h5>
        </section>
        <div style="display: none"><?php echo e($total = 0); ?></div>
        <?php if($producte == []): ?>
            <article>
                <h2>No hay productos en el carrito</h2>
            </article>
        <?php else: ?>
            <?php $__currentLoopData = $producte; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $productec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="display: none"> <?php echo e($total += round($productec->price/100, 2)); ?></div>
                <article class="shoppingcart-main-article shoppingcart-main-article-boxshadowNormal"
                    id="<?php echo e($productec->id); ?>">
                    <a href="<?php echo e(route('product.show', ['id' => $productec->id])); ?>">
                        <?php if($productec->getMainImage() != null): ?>
                            <img class="shoppingcart-main-article-productImage"
                                src="<?php echo e(asset('storage/img/' . $productec->getMainImage())); ?>" />
                        <?php else: ?>
                            <img class="shoppingcart-main-article-productImage"
                                src="<?php echo e(asset('/images/imagesNotFound.webp' . $productec->getMainImage())); ?>" />
                        <?php endif; ?>
                    </a>
                    <div>
                        <a href="<?php echo e(route('product.show', ['id' => $productec->id])); ?>">
                            <h3 class="shoppingcart-main-article-productName"><?php echo e($productec->name); ?></h3>
                        </a>
                        <p class="shoppingcart-main-article-productDescription">
                            <?php echo e($productec->description); ?>

                        </p>
                    </div>
                    <button class="shoppingcart-main-article-productDelete" title="Eliminar producto de la lista">
                        <span class="material-symbols-outlined shoppingcart-main-article-productDelete-span">
                            delete
                        </span>
                    </button>
                    <h3 class="shoppingcart-main-article-productPrice"> <?php echo e(round($productec->price/100, 2)); ?> €</h3>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <aside class="shoppingcart-aside">
            <h2>Resumen</h2>
            <p>Total (impuestos includidos)</p>
            <p class="shoppingcart-aside-preufinal"><?php echo e($total); ?>€</p>
            <hr>
            <ul class="userForm-form-error">
                <?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>{<?php echo $error; ?>}</li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <a class="button-newShop" href=<?php echo e(route('shoppingCart.confirmOrder')); ?>>
                Realizar pedido
                
            </a>
        </aside>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\prj\DAW\marketplace_github\Marketplace\marketPlace\resources\views/shoppingCart/shoppingCart.blade.php ENDPATH**/ ?>