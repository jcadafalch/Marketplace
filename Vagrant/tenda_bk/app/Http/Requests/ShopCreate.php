<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopCreate extends FormRequest
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
           'shopName' => 'required|min:5',
           'name' => 'required|max:30',
           'nif' =>  ['required', 'regex:/^\d{8,8}[a-zA-Z]$/'],
           'profilePhoto' => 'required|image|mimes:png,jpg,jpeg'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute no puede estar vacio.',
            'min' => [ 'string' => 'El campo :attribute tiene que tener como minimo :min caracteres.',
            ],
            'max' => ['string' => 'El nombre del propietario no puede superar :max caracteres'
            ],
            'image' => 'Solo se pueden cargar imagenes.',
            'mimes' => 'Formatos admtidos: png, jpg, jpeg.',
            'regex' => 'Formato de Dni incorrecto.'
        ];
    }

    public function attributes()
    {
    return [
        'shopName' => 'Nombre de la tienda',
        'name' => 'Nombre del Propietario',
        'nif' => 'Nif o Dni',
        'profilePhoto' => 'Foto de Perfil'
    ];
}
}
