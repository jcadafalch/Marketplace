<?php $__env->startSection('title', 'Registro'); ?>

<?php $__env->startSection('content'); ?>
    <div class="userForm">
        <div class="userForm-title">
            <a href="<?php echo e(route('landingPage')); ?>"><img class='userForm-logo' src="<?php echo e(asset('/images/logo.png')); ?>"
                    alt="Logo" /></a>
        </div>
        <form class="userForm-form" action="<?php echo e(route('auth.store')); ?>" method="post">
            <?php echo csrf_field(); ?>
            <div class="userForm-form-label">
                <h3>Registro</h3>
            </div>
            <div class="userForm-form-item">
                <label for="nombreUsuario">Nombre de usuario</label>
                <input type="text" name="nombreUsuario" value="<?php echo e(old('nombreUsuario')); ?>" required>

            </div>
            <div class="userForm-form-item">
                <label for="email">E-Mail</label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required>
            </div>
            <div class="userForm-form-item">
                <label for="contraseña">Contraseña</label>
                <input type="password" name="contraseña" required>
            </div>
            <div class="userForm-form-item">
                <label for="confirmaContraseña">Confirma tu contraseña</label>
                <input type="password" name="confirmaContraseña" required>
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Registrase</button>
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
        <div class="userForm-form-help already-account">
            <p>¿Ya tienes cuenta? <a href="<?php echo e(Route('auth.login')); ?>">Inicia sesión</a></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.masterAuth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/register.blade.php ENDPATH**/ ?>