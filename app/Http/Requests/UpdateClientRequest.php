<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clienteId = $this->route('id');

        return [
            'nome'            => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf'             => [
                'required',
                'string',
                'size:14',
                Rule::unique('clients', 'cpf')->ignore($clienteId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'data_nascimento.required' => 'A data de nascimento é obrigatória.',
            'data_nascimento.date' => 'A data de nascimento deve ser válida (YYYY-MM-DD).',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve estar no formato 000.000.000-00.',
            'cpf.unique' => 'Esse CPF já está cadastrado.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->formatFields();
    }

    protected function formatFields(): void
    {
        if ($this->filled('data_nascimento')) {
            try {
                $data = $this->data_nascimento;

                if (preg_match('/^\d{8}$/', $data)) {
                    $data = Carbon::createFromFormat('dmY', $data)->format('Y-m-d');
                } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $data)) {
                    $data = Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');
                }

                $this->merge(['data_nascimento' => $data]);
            } catch (\Exception $e) {
            }
        }

        if ($this->filled('cpf') && strlen($this->cpf) === 11 && ctype_digit($this->cpf)) {
            $this->merge([
                'cpf' => preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $this->cpf),
            ]);
        }
    }
}
