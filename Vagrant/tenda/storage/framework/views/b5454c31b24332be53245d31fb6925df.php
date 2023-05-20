<?php $__env->startSection('title', 'Editar Producto'); ?>

<?php $__env->startSection('content'); ?>
    <div class="userForm">
        <div class="userForm-title">
            <h3>Editar producto</h3>
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
                <input type="text" name="name" value="<?php echo e($product->name); ?>" required>
            </div>

            <div class="userForm-form-item">
                <label>Precio</label>
                <input type="number" name="price" value="<?php echo e($product->price); ?>" required>
            </div>

            <div class="userForm-form-item">
                <label>Detalle</label>
                <textarea rows="5" cols="40" maxlength='200' minlength='10' name="detail" required><?php echo e($product->description); ?></textarea>
            </div>
            <div class="upload-container">
                <div class="drop-area">
                    <label for="file-input"> Imagen destacada </label>
                    <input name="file" type="file" id="file-input" accept="image/*" value="<?php echo e(old('file')); ?>"
                        hidden />
                    <!-- Image upload input -->
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
                        <input name="otrasImagenes[]" type="file" multiple data-max_length="3" class="upload__inputfile"
                            value="<?php echo e(old('otrasImagenes[]')); ?>">
                    </label>
                </div>
                <div class="upload__img-wrap"></div>
            </div>
            <div class="userForm-form-item">
                <div id="multiselect" class="multiselect">
                    <div class="selectBox" onclick="showCheckboxes()">
                        <select>
                            <option>Selecciona categorias</option>
                        </select>
                        <div class="overSelect"></div>
                    </div>
                    <div id="checkboxes">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label for="<?php echo e($item->name); ?>">
                                <input type="checkbox" name="category[]" id="<?php echo e($item->name); ?>"
                                    value="<?php echo e($item->name); ?>"
                                    <?php $__currentLoopData = $productCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($productCategory === $item->name): ?>
                                            checked
                                        <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> /><?php echo e($item->name); ?></label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\prj\DAW\marketplace_github\Marketplace\marketPlace\resources\views/shop/editProductForm.blade.php ENDPATH**/ ?>