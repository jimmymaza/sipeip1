<?php

namespace Database\Factories;

use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;

class RolFactory extends Factory
{
    protected $model = Rol::class;

    public function definition()
    {
        return [
            'IdRol' => $this->faker->unique()->randomNumber(),
            'Nombre' => $this->faker->word(),
            // Otros campos que tenga tu tabla rol, si hay
        ];
    }
}
