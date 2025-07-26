<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** 
     * Verifica que la página de creación de usuarios carga correctamente.
     */
    public function test_pagina_usuario_carga()
    {
        // Crear un usuario para autenticarse antes de hacer la petición
        $usuarioAutenticado = User::factory()->create();

        // Simula que el usuario está autenticado y hace GET a la ruta
        $response = $this->actingAs($usuarioAutenticado)->get('/usuarios/create');

        // Verifica que la página carga con status 200 OK
        $response->assertStatus(200);
    }

    /**
     * Verifica que un usuario puede crearse vía POST y se almacena en la base de datos.
     */
    public function test_usuario_crea_via_post()
    {
        // Crear un usuario para autenticarse (quien hace la petición)
        $usuarioAutenticado = User::factory()->create();

        // Generar datos válidos para un nuevo usuario (sin guardar en BD)
        $userData = User::factory()->make()->toArray();

        // Encripta la clave que se usará para crear el usuario
        $userData['Clave'] = bcrypt('password');

        // Simula petición POST autenticada para crear un nuevo usuario
        $response = $this->actingAs($usuarioAutenticado)->post('/usuarios', $userData);

        // Verifica que se redirige a la lista de usuarios
        $response->assertRedirect('/usuarios');

        // Verifica que el usuario se guardó en la base de datos
        $this->assertDatabaseHas('usuarios', [
            'Correo' => $userData['Correo'],
        ]);
    }
}
