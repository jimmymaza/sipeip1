<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que un usuario se cree correctamente en la base de datos.
     */
    public function test_usuario_se_crea_correctamente()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('usuarios', [
            'IdUsuario' => $user->IdUsuario,
            'Correo' => $user->Correo,
        ]);
    }
}
