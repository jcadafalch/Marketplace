@extends('layouts.master')

@section('title', 'Crear tienda')

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
                    <input multiple name="file" type="file" id="file-input" accept="image/*" hidden />
                    <!-- Image upload input -->
                    <div class="preview-container hidden">
                        <div class="preview-image"></div>
                        <span class="file-name"></span>
                        <p class="close-button">Eliminar</p>
                    </div>
                </div>
            </div>

            <div class="userForm-form-uploadPhoto">
                <div class ="userForm-form-uploadPhoto-text">
                    <label>Otras Imagenes</label>      
                </div>
                <div class="userForm-form-uploadPhoto-button">
                    <input type="file" name="productImages" accept="image/*" multiple>
                </div>
            </div>
            
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Guardar</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/imgPreviw.js') }}"></script>

    <style>
        .upload-container {
            justify-content: space-between;
            align-items: center;
            width: 100%;
            position: relative;
            display: flex;
        }

        .drop-area {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
            text-align: center;
            --tw-border-opacity: 1;
            border-color: rgb(229 231 235 / var(--tw-border-opacity));
            border-style: dotted;
            border-width: 2px;
            border-radius: 0.375rem;
            width: 100%;
        }

        .drop-area.active {
            border-color: #2563eb;
        }

        .drop-area label {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity));
            font-size: 0.875rem;
            line-height: 1.25rem;
            padding: 1rem;
            cursor: pointer;
            width: 100%;
            height: 100%;
            display: block;
        }

        .hidden {
            display: none;
        }

        .file-name {
            display: block;
            font-weight: 500;
            font-size: 0.875rem;
            line-height: 1.25rem;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .preview-image {
            background-position: center;
            background-size: cover;
            border-radius: 0.375rem;
            width: 9rem;
            height: 9rem;
        }

        .close-button {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;

            --tw-text-opacity: 1;
            color: rgb(239 68 68 / var(--tw-text-opacity));

            font-size: 0.75rem;
            line-height: 1rem;

            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            --tw-border-opacity: 1;
            border-color: rgb(239 68 68 / var(--tw-border-opacity));
            border-width: 1px;
            border-radius: 0.375rem;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .preview-container {
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .flex {
            display: flex;
        }
    </style>
@endsection
