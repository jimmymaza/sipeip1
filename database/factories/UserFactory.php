<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Institucion;
use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'Cedula' => $this->faker->unique()->numerify('##########'), // 10 dígitos
            'Nombre' => $this->faker->firstName,
            'Apellido' => $this->faker->lastName,
            'Correo' => $this->faker->unique()->safeEmail,
            'Telefono' => $this->faker->numerify('09########'), // celular Ecuador
            'Clave' => Hash::make('password'), // clave por defecto segura para pruebas
            'IdInstitucion' => Institucion::factory(), // Crea o usa una institución válida
            'IdRol' => Rol::factory(), // Crea o usa un rol válido
            'FechaCreacion' => now(),
        ];
    }
}
