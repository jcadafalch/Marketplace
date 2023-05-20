<?php $__env->startSection('title', 'Craft Made'); ?>

<?php $__env->startSection('content'); ?>
    <section class='landing'>
        <?php for($i = 0; $i < count($titles); $i++): ?>
            <article class="landing-card">
                <h2 class="landing-title"><?php echo e($titles[$i]); ?></h2>
                <ul class="landing-products">
                    <?php $__currentLoopData = $products[$i]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($i < 8): ?>
                            <li>
                                <a href="<?php echo e(route('product.show', ['id' => $item->id])); ?>"><img class="landing-image"
                                        src="<?php echo e(env('API_URL_IMAGES') . $item->url); ?>" alt="Imagen de producto" />
                                    <p><?php echo e($item->name); ?></p>
                                    <p><?php echo e($item->price); ?>€</p>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <a id="<?php echo e($i); ?>" href="<?php echo e(route('landingPage.showAll', ['id' => $i])); ?>"><button
                        class="button-landing"> Ver todo </button></a>
            </article>
        <?php endfor; ?>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\prj\DAW\marketplace_github\Marketplace\marketPlace\resources\views/landingPage.blade.php ENDPATH**/ ?>