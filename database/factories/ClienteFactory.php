<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'    => $this->faker->firstName(),
            'apellido'  => $this->faker->lastName(),
            'ci'        => $this->faker->unique()->numerify('########'), // CI/NIT aleatorio
            'telefono'  => $this->faker->optional()->phoneNumber(),
            'email'     => $this->faker->unique()->safeEmail(),
            'direccion' => $this->faker->optional()->address(),
            'activo'    => $this->faker->boolean(80), // 80% de probabilidad que sea TRUE
        ];
    }
}
