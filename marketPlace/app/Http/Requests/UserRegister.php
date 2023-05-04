<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegister extends FormRequest
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
            'nombreUsuario' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'contraseña' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[!@#$%^&*(),.?":{}|<>]/'],
            'confirmaContraseña' => 'required|string|min:8|same:contraseña'
        ];
    }

    public function messages() : array 
    {
        return [
            'required' => 'El campo :attribute no puede estar vacio',
            'same' => 'La contraseñas no conciden',
            'unique' => 'Este correo ya está registrado',
            'regex' => 'La contraseña tiene que tener: mínimo 8 caracteres, 1 carácter en mayúsculas y al menos 1 carácter especial',
            'min' => ['string' => 'El campo :attribute tiene que tener como minimo :min caracteres']
            
        ];
    }
}
