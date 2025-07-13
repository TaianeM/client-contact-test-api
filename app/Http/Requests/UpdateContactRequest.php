<?php

namespace App\Http\Requests;

use App\Rules\ValidDescriptionContact;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
        'cliente_id' => 'required|exists:clients,id',
        'tipo'       => 'required|in:email,telefone',
        'descricao'  => array_merge(
            ['required'],
            $this->filled('tipo') ? [new ValidDescriptionContact($this->input('tipo'))] : []
        ),
    ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'O cliente_id é obrigatório.',
            'cliente_id.exists'   => 'O cliente informado não existe.',
            'tipo.required'       => 'O tipo é obrigatório.',
            'tipo.in'             => 'O tipo deve ser email ou telefone.',
            'descricao.required'  => 'A descrição é obrigatória.',
        ];
    }
}
