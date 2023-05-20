<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>

    <div class="userForm">
        <div class="userForm-title">
            <a href="<?php echo e(route('landingPage')); ?>"><img class='userForm-logo' src="<?php echo e(asset('/images/logo.png')); ?>"
                    alt="Logo" /></a>
        </div>
        <form class="userForm-form" method="post">
            <?php echo csrf_field(); ?>
            <div class="userForm-form-title">
                <h3>Iniciar sesión</h3>
            </div>
            <div class="userForm-form-item">
                <label>Dirección de E-Mail</label>
                <input type="email" name="email">
            </div>
            <div class="userForm-form-item">
                <label>Contraseña</label>
                <input type="password" name="password">
                <span><a href="<?php echo e(Route('auth.recoveryPassword')); ?>">¿Has olvidado la contraseña?</a></span>
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Iniciar sesión</button>
            </div>
            <div class="userForm-form-item" role="alert">
                <p class="userForm-form-error"><?php echo e(Session::get('message')); ?></p>
                <p><?php echo e(Session::get('emailMessage')); ?></p>
            </div>
        </form>
        <div class="userForm-form-help already-account">
            <p>¿No tienes cuenta? <a href="<?php echo e(Route('auth.register')); ?>">Registrate aquí</a></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.masterAuth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>