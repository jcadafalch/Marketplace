<?php $__env->startSection('title', 'Crear tienda'); ?>

<?php $__env->startSection('content'); ?>
    <div class="userForm">
        <div class="userForm-title">
            <div class="userForm-form-label">
                <h3>Dar de alta tu tienda</h3>
            </div>
        </div>
        <form class="userForm-form" action="<?php echo e(route('register.createNewShop')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="container">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type='file' name="profilePhoto" id="shopImageUpload" class="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="shopImageUpload"></label>
                    </div>
                    <div class="avatar-preview">
                        <div class="avatar-preview-img imagePreview">
                            <img class="imageUploaded" src="<?php echo e(asset('storage/img/profile/' . Auth::user()->path)); ?>"
                            onerror="this.src='<?php echo e(asset('images/imagesNotFound.webp')); ?>'" alt="Imagen de perfil">
                        </div>
                    </div>
                </div>
            </div>
            <div class="userForm-form-item">
                <label>Nombre de la tienda</label>
                <input type="text" name="shopName" value="<?php echo e(old('shopName')); ?>">
            </div>
            <div class="userForm-form-item">
                <label>Nombre del Propietario</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>">
            </div>
            <div class="userForm-form-item">
                <label>Nif o Dni</label>
                <input type="text" name="nif" value="<?php echo e(old('nif')); ?>">
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Enviar</button>
            </div>
             <?php if($errors->any()): ?>
            <div class="userForm-form-item">
                <ul class="userForm-form-error">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>
        </form>
    </div>
    <script src="<?php echo e(asset('js/profileImgPreview.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/shop/createNewShop.blade.php ENDPATH**/ ?>