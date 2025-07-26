<?php

namespace Database\Factories;

use App\Models\Institucion;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstitucionFactory extends Factory
{
    protected $model = Institucion::class;

    public function definition()
    {
        return [
            'Nombre' => $this->faker->company,
            'Codigo' => $this->faker->unique()->numerify('###'),  // o el formato que corresponda
            'Subsector' => $this->faker->word,
            'NivelGobierno' => $this->faker->randomElement(['Nacional', 'Provincial', 'Cantonal']),
            'Estado' => $this->faker->boolean(90), // 90% chances true
        ];
    }
}
