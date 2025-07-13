<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = \App\Models\Client::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'data_nascimento' => $this->faker->date('Y-m-d', '2005-01-01'),
        ];
    }
}
