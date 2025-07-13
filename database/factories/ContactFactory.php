<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        $tipo = $this->faker->randomElement(['telefone', 'email']);

        return [
            'cliente_id' => Client::factory(),
            'tipo' => $tipo,
            'descricao' => $tipo === 'telefone'
                ? $this->faker->numerify('(69) 9####-####')
                : $this->faker->unique()->safeEmail,
        ];
    }
}
