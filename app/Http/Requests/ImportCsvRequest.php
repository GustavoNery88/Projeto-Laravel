<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportCsvRequest extends FormRequest
{
    /**
     * Autoriza a requisição
     */
    public function authorize(): bool
    {
        return true; // ou regra de permissão
    }

    /**
     * Regras de validação
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ];
    }

    /**
     * Mensagens personalizadas
     */
    public function messages(): array
    {
        return [
            'file.required' => 'O campo arquivo é obrigatório.',
            'file.file'     => 'Arquivo inválido.',
        ];
    }
}
