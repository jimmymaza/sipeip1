<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Rol;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolTest extends TestCase
{
    use RefreshDatabase;
    public function test_rol_crea_correctamente()
    {
        $rol = Rol::factory()->create();

        $this->assertDatabaseHas('rol', [
            'IdRol' => $rol->IdRol,
            'Nombre' => $rol->Nombre,
        ]);
    }
}
