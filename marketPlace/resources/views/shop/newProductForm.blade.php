@extends('layouts.master')

@section('title', 'Añadir Producto')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <h3>Añadir producto</h3>
        </div>
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        <form class="userForm-form" method="post">
            @csrf
            <div class="userForm-form-item">
                <label>Nombre</label>
                <input type="text" name="name">
            </div>

            <div class="userForm-form-item">
                <label>Precio</label>
                <input type="number" name="price">
            </div>

            <div class="userForm-form-item">
                <label>Detalle</label>
                <textarea rows="5" cols="40" maxlength='200' minlength='10' name="detail"></textarea>
            </div>
            {{-- <div class="userForm-form-uploadPhoto">
                <div class ="userForm-form-uploadPhoto-text">
                    <label>Imagen destacada</label>      
                </div>
                <div class="userForm-form-uploadPhoto-button">
                    <input type="file" name="productMainImage" accept="image/*">
                </div>
            </div> --}}
            <div class="upload-container">
                <div class="drop-area">
                    <label for="file-input"> Imagen destacada </label>
                    <input name="file" type="file" id="file-input" accept="image/*" hidden />
                    <!-- Image upload input -->
                    <div class="preview-container hidden">
                        <div class="preview-image"></div>
                        <span class="file-name"></span>
                        <p class="close-button">Eliminar</p>
                    </div>
                </div>
            </div>

            {{-- <div class="userForm-form-uploadPhoto">
                <div class ="userForm-form-uploadPhoto-text">
                    <label>Otras Imagenes</label>      
                </div>
                <div class="userForm-form-uploadPhoto-button">
                    <input type="file" name="productImages" accept="image/*" multiple>
                </div>
            </div> --}}

            <div class="upload__box drop-area">
                <div class="upload__btn-box">
                    <label class="upload__btn">
                        <p>Otras Imagenes</p>
                        <input type="file" multiple="" data-max_length="3" class="upload__inputfile">
                    </label>
                </div>
                <div class="upload__img-wrap"></div>
            </div>

            <div class="userForm-form-button">
                <button class="button-form" type="submit">Guardar</button>
            </div>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{ asset('js/imgPreviw.js') }}"></script>
@endsection
