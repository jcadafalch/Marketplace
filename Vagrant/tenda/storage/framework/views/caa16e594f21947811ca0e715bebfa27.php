<?php $__env->startSection('title', 'Perfil'); ?>

<?php $__env->startSection('content'); ?>
    <section class="profile">
        <article class="user-content">
            <div class="user-img">
                <div class="user-img-imagePreview">
                    <img src="<?php echo e(asset('storage/img/profile/' . Auth::user()->path)); ?>"
                        onerror="this.src='<?php echo e(asset('images/imagesNotFound.webp')); ?>'" alt="Imagen de perfil">
                </div>
            </div>
            <div class="user-info">
                <p class="user-name"><?php echo e(Auth::user()->name); ?></p>

                <a href=<?php echo e(route('user.profile')); ?>><button class="button-UserProfile">Modificar perfil</button></a>
                <?php if($shop != null): ?>
                    <a href=<?php echo e(route('shop.show', ['shopName' => $shop->name])); ?>><button class="button-UserProfile">Mi
                            tienda</button></a>
                    <a href=<?php echo e(route('shop.edit')); ?>><button class="button-UserProfile">Editar mi tienda</button></a>
                <?php else: ?>
                    <a href=<?php echo e(route('shop.createNewShop')); ?>><button class="button-UserProfile">Mi tienda</button></a>
                <?php endif; ?>
            </div>
        </article>
        <article class="user-order">
            <details class="user-order-history">
                <summary class="user-order-history-title">Pedidos realizados</summary>
                <ul class="user-order-history-list">
                    <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('order.show' /*, ['shopName' => $shop->name]*/)); ?>">
                            <li class="order-product" id="1">
                                <img class="order-product-image"
                                    src="<?php echo e(asset('storage/img/shopProfile/' . $shop->getLogo()->url)); ?>"
                                    onerror="this.src='<?php echo e(asset('/images/imagesNotFound.webp')); ?>'" alt="Logo de la tienda">
                                <div>
                                    <h3 class="order-product-name"><?php echo e($shop->name); ?></h3>
                                </div>
                                <div>
                                    <p class="order-product-price"> Fecha </p>
                                    <p class="order-product-price"> Entregado </p>
                                    <p class="order-product-price"> Total: € </p>
                                </div>
                            </li>
                        </a>
                        <hr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </details>
        </article>
        <?php if($shop != null): ?>
            <article class="user-order">
                <details class="user-order-history">
                    <summary class="user-order-history-title">Productos vendidos</summary>
                    <ul class="user-order-history-list">
                        <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('order.selled' /*, ['id' => ]*/)); ?>">
                                <li class="order-product" id="1">
                                    <img class="order-product-image"
                                        src="<?php echo e(asset('storage/img/shopProfile/' . $shop->getLogo()->url)); ?>"
                                        onerror="this.src='<?php echo e(asset('/images/imagesNotFound.webp')); ?>'"
                                        alt="Logo de la tienda">
                                    <div>
                                        <h3 class="order-product-name"><?php echo e($shop->name); ?></h3>
                                    </div>
                                    <div>
                                        <p class="order-product-price"> Fecha </p>
                                        <p class="order-product-price"> Entregado </p>
                                        <p class="order-product-price"> Total: € </p>
                                    </div>
                                </li>
                            </a>
                            <hr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </details>
            </article>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\prj\DAW\marketplace_github\Marketplace\marketPlace\resources\views/user/userProfile.blade.php ENDPATH**/ ?>