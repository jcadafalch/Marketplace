<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

    <title><?php echo $__env->yieldContent('title'); ?></title>
</head>

<body>
<?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <main class="error"> 
        <div class="error-image"><img src="<?php echo e(asset('/images/Error.png')); ?>" alt="Error"/></div>
        <article class="error-message">
            <?php echo $__env->yieldContent('content'); ?>
        </article>
         <a href="<?php echo e(route('home.index')); ?>"><button class="button-error">Página de inicio</button></a>
    </main>
<?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH C:\prj\DAW\marketplace_github\Marketplace\marketPlace\resources\views/layouts/masterError.blade.php ENDPATH**/ ?>