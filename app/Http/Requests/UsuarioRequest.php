<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $usuario = $this->route('usuario'); // Obtém o usuário da rota, se existir
        return [
            'nome' => 'required',
            'email' => 'required|email|unique:usuarios,email,' . ($usuario ? $usuario->id : 'null'), // Regra única para email, ignorando o usuário atual na edição
            'password' => $this->isMethod('POST') ? 'required|min:8' : 'nullable|min:8',
        ];
    }
}
