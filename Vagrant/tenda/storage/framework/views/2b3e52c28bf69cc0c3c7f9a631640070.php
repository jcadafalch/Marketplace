<?php $__env->startSection('title', 'Perfil'); ?>

<?php $__env->startSection('content'); ?>
    <section class="userForm">
        <section class="userForm-title">
            <div class="userForm-form-label">
                <h3>Perfil publico</h3>
            </div>
        </section>
        <form class="userForm-form" action="<?php echo e(route('user.changeProfile')); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('patch'); ?>
            <div class="container">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type='file' name="profilePhoto" id="imageUpload" class="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload"></label>
                    </div>
                    <div class="avatar-preview">
                        <div class="avatar-preview-img imagePreview">
                            <img class="imageUploaded" src="<?php echo e(asset('storage/img/profile/' . Auth::user()->path)); ?>"
                                onerror="this.src='<?php echo e(asset('images/imagesNotFound.webp')); ?>'" alt="Error">
                        </div>
                    </div>
                </div>
            </div>
            <div class="userForm-form-userInfo">
                <div class="userForm-form-userInfo-name">
                    <label>Nombre</label>
                </div>
                <div class="userForm-form-userInfo-userName">
                    <input maxlength="25" type="text" name="userName" value="<?php echo e(Auth::user()->name); ?>"
                        placeholder="<?php echo e(Auth::user()->name); ?>">
                </div>
            </div>
            <div class="userForm-form-item">
                <label>Cambiar contraseña</label>
                <input type="password" name="password" placeholder="Contraseña actual">
            </div>
            <div class="userForm-form-item">
                <input type="password" name="newPassword" placeholder="Nueva Contraseña">
            </div>
            <div class="userForm-form-item">
                <input type="password" name="repeatNewPassword" placeholder="Repita nueva Contraseña">
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit" id="imageUpload">Guardar Cambios</button>
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
            <?php if(Session::get('error') && Session::get('error') != null): ?>
                <div class="userForm-form-error"><?php echo e(Session::get('error')); ?></div>
                <?php
                    Session::put('error', null);
                ?>
            <?php endif; ?>
        </form>
    </section>

    <script src="<?php echo e(asset('js/profileImgPreview.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/user/profile.blade.php ENDPATH**/ ?>