<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $identifier = $this->input('nombreU') 
            ?? $this->input('email') 
            ?? $this->input('username') 
            ?? $this->input('usuario');

        $password = $this->input('contrasena') 
            ?? $this->input('password') 
            ?? $this->input('clave');

        $this->merge([
            'nombreU' => $identifier,
            'contrasena' => $password,
        ]);
    }

    public function rules(): array
    {
        return [
            'nombreU' => 'required|string',
            'contrasena' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nombreU.required' => 'El usuario o correo es obligatorio.',
            'contrasena.required' => 'La contraseña es obligatoria.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $validator->errors()
        ], 422));
    }
}
