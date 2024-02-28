<?php

namespace Tests\Unit\Controllers\Api\V2;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompleteTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_mark_task_as_completed()
    {
        // Créer un utilisateur et une tâche
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        // Simuler la requête avec le statut de complétion de la tâche
        $response = $this->actingAs($user)->putJson("/api/v2/tasks/{$task->id}/complete", ['not_completed' => false]);

        // Vérifier que la réponse a le code de statut 200
        $response->assertStatus(200);

        // Rafraîchir la tâche depuis la base de données
        $task->refresh();

        // Vérifier que le statut de complétion de la tâche a été mis à jour correctement
        $this->assertFalse($task->not_completed);
    }

    public function test_mark_task_as_not_completed()
    {
        // Créer un utilisateur et une tâche
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id, 'not_completed' => false]);

        // Simuler la requête avec le statut de non-complétion de la tâche
        $response = $this->actingAs($user)->putJson("/api/v2/tasks/{$task->id}/complete", ['not_completed' => true]);

        // Vérifier que la réponse a le code de statut 200
        $response->assertStatus(200);

        // Rafraîchir la tâche depuis la base de données
        $task->refresh();

        // Vérifier que le statut de complétion de la tâche a été mis à jour correctement
        $this->assertTrue($task->not_completed);
    }
}
