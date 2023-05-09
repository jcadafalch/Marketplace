<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreate extends FormRequest
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
           'name' => 'required|min:20',
           'price' => 'required|min:20',
           'details' => 'required|min:50',
           'file' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute no puede estar vacio.',
            'min' => [ 'string' => 'El campo :attribute tiene que tener como minimo :min caracteres.',
            ],
        ];
    }
}
