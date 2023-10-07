<?php

namespace Tests\Feature;

use App\Models\Receta;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecetasControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_obtener_un_listado_de_recetas()
    {
        // Preparar el escenario
        $user = User::factory()->create();
        $receta = Receta::factory(['user_id' => $user->id])->create();

        // Realizar las acciones necesarias
        $respuesta = $this->getJson('/api/recetas');

        // Comprobar el estado final
        $respuesta->assertOk();
        $respuesta->assertJson([$receta->toArray()]);
    }

    public function test_un_usuario_puede_crear_una_receta()
    {
        // Preparar el escenario
        $user = User::factory()->create();
        $this->actingAs($user);

        // Realizar las acciones necesarias
        $respuesta = $this->postJson('/api/recetas', [
            'title' => 'Este es el titulo de mi receta',
            'description' => 'Esta es la descripcion de mi receta',
        ]);

        // Comprobar el estado final
        $respuesta->assertCreated();
        $respuesta->assertJson([
            'receta' => [
                'title' => 'Este es el titulo de mi receta',
                'description' => 'Esta es la descripcion de mi receta',
            ]
        ]);
        $this->assertDatabaseHas('recetas', [
            'title' => 'Este es el titulo de mi receta',
            'description' => 'Esta es la descripcion de mi receta',
        ]);
    }

    public function test_actualizar_una_receta()
    {
        // Preparar escenario
        $user = User::factory()->create();
        $receta = Receta::factory(['user_id' => $user->id])->create();
        $this->actingAs($user);

        // Realizar acciones
        $respuesta = $this->putJson("/api/recetas/{$receta->id}", [
            'title' => 'Mi receta actualizada',
            'description' => 'Mi nueva descripcion',
        ]);

        // Comprobar estado final
        $respuesta->assertOk();
        $respuesta->assertJson([
            'receta' => [
                'title' => 'Mi receta actualizada',
                'description' => 'Mi nueva descripcion',
            ],
        ]);
        $this->assertDatabaseHas('recetas', [
            'title' => 'Mi receta actualizada',
            'description' => 'Mi nueva descripcion',
        ]);
        $this->assertDatabaseMissing('recetas', [
            'title' => $receta->title,
            'description' => $receta->description,
        ]);
    }

    public function test_borrar_una_receta()
    {
        $user = User::factory()->create();
        $receta = Receta::factory(['user_id' => $user->id])->create();
        $this->actingAs($user);

        $respuesta = $this->deleteJson("/api/recetas/{$receta->id}");

        $respuesta->assertNoContent();
        $this->assertDatabaseMissing('recetas', [
            'title' => $receta->title,
            'description' => $receta->description,
        ]);
    }
}
