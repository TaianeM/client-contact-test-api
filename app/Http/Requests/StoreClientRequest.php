<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
         return [
            'nome'            => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf'             => 'required|string|size:11|unique:clients,cpf',
        ];
    }

      public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'cpf.size' => 'O CPF deve conter exatamente 11 dígitos.',
            'cpf.unique' => 'Esse CPF já está cadastrado.',
        ];
    }
}
