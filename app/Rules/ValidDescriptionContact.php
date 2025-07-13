<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDescriptionContact implements ValidationRule
{
    protected string $tipo;

    public function __construct(string $tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @param  \Closure(string): void  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->tipo === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $fail('A descrição deve conter um e-mail válido.');
        }

        if ($this->tipo === 'telefone' && !preg_match('/^\d{10,15}$/', $value)) {
            $fail('A descrição deve conter um telefone válido (apenas números, com DDD)');
        }

        if (!in_array($this->tipo, ['email', 'telefone'])) {
            $fail('O tipo de contato é inválido.');
        }
    }
}
