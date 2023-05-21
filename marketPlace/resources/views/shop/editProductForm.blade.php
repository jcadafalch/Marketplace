@extends('layouts.master')

@section('title', 'Editar Producto')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <h3>Editar producto</h3>
        </div>
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <form class="userForm-form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="userForm-form-item">
                <label>Nombre</label>
                <input type="text" name="name" value="{{ $product->name }}" required>
            </div>

            <div class="userForm-form-item">
                <label>Precio</label>
                <input type="number" name="price" value="{{ $product->price }}" required>
            </div>

            <div class="userForm-form-item">
                <label>Detalle</label>
                <textarea rows="5" cols="40" maxlength='200' minlength='10' name="detail" required>{{ $product->description }}</textarea>
            </div>
            <div class="upload-container">
                <div class="drop-area">
                    <label for="file-input"> Imagen destacada </label>
                    <input name="file" type="file" id="file-input" accept="image/*"
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
                        Otras Imagenes
                        <input name="otrasImagenes[]" type="file" multiple data-max_length="3" class="upload__inputfile">
                    </label>
                </div>
                <div class="upload__img-wrap"></div>
            </div>
            <div class="checkbox-container">
                <div id="multiselect" class="multiselect checkbox-dropdown">
                    <p>Categorias</p>
                    <ul id="checkboxes" class="checkbox-dropdown-list">
                        @foreach ($categories as $item)
                            <li>
                                <label for="{{ $item->name }}">
                                    <input type="checkbox" name="category[]" class="checkbox" id="{{ $item->name }}"
                                        value="{{ $item->name }}"
                                        @foreach ($productCategories as $productCategory)
                                        @if ($productCategory === $item->name)
                                            checked
                                        @endif @endforeach />{{ $item->name }}</label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div id="multiselect2" class="multiselect checkbox-dropdown">
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
            @if ($errors->any())
                <div class="error-list">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>

    <script src="{{ asset('js/imgPreviw.js') }}"></script>
@endsection
