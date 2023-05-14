<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:5', 'regex:/^[A-Za-z0-9\s]+$/'],
            'price' => 'required|min:1',
            'detail' => 'required|min:10',
            'category' => 'required',
            'otrasImagenes' => [
                function ($attribute, $value, $fail) {
                    if (count($value) > 5) {
                        $fail('Solo se permiten subir hasta 5 imágenes en Otras imágenes');
                    }
                },
            ],
            'otrasImagenes.*' => 'image|mimes:png,jpg,jpeg'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute no puede estar vacio.',
            'min' => [
                'string' => 'El campo :attribute tiene que tener como minimo :min caracteres.',
            ],
            'max' => [
                'string' => 'Solo añadir :max imágenes'
            ],
            'image' => 'Solo se pueden cargar imagenes.',
            'mimes' => 'Formatos admtidos: png, jpg, jpeg.',
            'regex' => 'El nombre contiene valores no permitidos.'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'price' => 'precio',
            'detail' => 'detalles',
            'category' => 'categoria'
        ];
    }
}
