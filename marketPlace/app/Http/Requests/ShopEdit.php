<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopEdit extends FormRequest
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
            'shopDescription' => 'max:30',
            'profileImg' => 'image|mimes:png,jpg,jpeg',
            'shopBanner' => 'image|mimes:png,jpg,jpeg'
         ];
    }

    public function messages(): array
    {
        return [
            'min' => [ 'string' => 'El campo :attribute tiene que tener como minimo :min caracteres.',
            ],
            'image' => ':attribute, solo se pueden cargar imagenes .',
            'mimes' => 'Formatos admtidos: png, jpg, jpeg.',
        ];
    }

    public function attributes()
    {
    return [
        'shopDescription' => 'La descripción',
        'profileImg' => 'En la foto de perfil',
        'shopBanner' => 'En la foto del Banner de la tienda',
    ];
}
}
