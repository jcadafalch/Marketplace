<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEdit extends FormRequest
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
            'userName' => 'max:25|nullable',
            'profileImg' => 'image|mimes:png,jpg,jpeg|nullable',
            'password' => 'min:8|nullable',
            'newPassword' => ['regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[!@#$%^&*(),.?":{}|<>]/', 'nullable'],
            'repeatNewPassword' => 'same:newPassword|nullable' 
         ];
    }

    public function messages(): array
    {
        return [
            'min' => 'La :attribute tiene que tener como minimo :min caracteres.',
            'max' => 'La descripción de la tienda no puede superar :max caracteres',
            'image' => ':attribute, solo se pueden cargar imagenes .',
            'mimes' => 'Formatos admtidos: png, jpg, jpeg.',
            'required' => 'El campo :attribute no puede estar vacio',
            'same' => 'Las contraseñas no conciden',
            'regex' => 'La contraseña tiene que tener: mínimo 8 caracteres, 1 carácter en mayúsculas y al menos 1 carácter especial'
        ];
    }

    public function attributes()
    {
    return [
        'newPassword' => 'contraseña',
        'profileImg' => 'En la foto de perfil',
    ];
}
}