<?php $__env->startSection('title', 'Añadir Producto'); ?>

<?php $__env->startSection('content'); ?>
    <div class="userForm">
        <div class="userForm-title">
            <h3>Añadir producto</h3>
        </div>
        <?php if(Session::has('message')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(Session::get('message')); ?>

            </div>
        <?php endif; ?>
        <?php if(Session::has('error')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(Session::get('error')); ?>

            </div>
        <?php endif; ?>
        <form class="userForm-form" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="userForm-form-item">
                <label>Nombre</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required>
            </div>

            <div class="userForm-form-item">
                <label>Precio</label>
                <input type="number" step="0.10" min="0.00" name="price" value="<?php echo e(old('price')); ?>" required>
            </div>

            <div class="userForm-form-item">
                <label>Detalle</label>
                <textarea rows="5" cols="40" maxlength='200' minlength='10' name="detail" required><?php echo e(old('detail')); ?></textarea>
            </div>
            <div class="upload-container">
                <div class="drop-area">
                    <label for="file-input"> Imagen destacada </label>
                    <input name="file" type="file" id="file-input" accept="image/*" value="<?php echo e(old('file')); ?>"
                        hidden />

                    <div class="preview-container hidden">
                        <div class="preview-image"></div>
                        <span class="file-name"></span>
                        <p class="close-button">Eliminar</p>
                    </div>
                </div>
            </div>
            <div class="upload__box drop-area">
                <div class="upload__btn-box">
                    <label class="upload__btn">
                        <p>Otras Imagenes</p>
                        <input name="otrasImagenes[]" type="file" multiple data-max_length="5" accept="image/*"
                            class="upload__inputfile" value="<?php echo e(old('otrasImagenes[]')); ?>">
                    </label>
                </div>
                <div class="upload__img-wrap"></div>
            </div>
            <div class="checkbox-container">

                <div id="multiselect" class="multiselect checkbox-dropdown">
                    <p>Categorias</p>
                    
                    <ul id="checkboxes" class="checkbox-dropdown-list">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <label for="<?php echo e($item->name); ?>">
                                    <input type="checkbox" name="category[]" class="checkbox" id="<?php echo e($item->name); ?>"
                                        value="<?php echo e($item->name); ?>" /><?php echo e($item->name); ?></label>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <div id="multiselect2" class="multiselect checkbox-dropdown" hidden>
                    <p>Subcategorias</p>
                    
                    <ul id="checkboxes2" class="checkbox-dropdown-list">
                        <li class="check">

                        </li>
                    </ul>
                </div>
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Guardar</button>
            </div>
            <?php if($errors->any()): ?>
                <div class="error-list">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script src="<?php echo e(asset('js/imgPreviw.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\prj\DAW\marketplace_github\Marketplace\marketPlace\resources\views/shop/newProductForm.blade.php ENDPATH**/ ?>