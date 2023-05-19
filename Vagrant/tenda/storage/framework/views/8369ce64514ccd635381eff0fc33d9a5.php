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
            <a href="<?php echo e(route('order.orderList')); ?>">Lista de pedidos Realizados</a>
            
        </article>
        <?php if($shop != null): ?>
        <a href="<?php echo e(route('order.selledList')); ?>">Lista de pedidos vendidos</a>
            
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/user/userProfile.blade.php ENDPATH**/ ?>