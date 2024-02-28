<?php

namespace Tests\Unit\Controllers\Api\V2;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_tasks_for_authenticated_user()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
    
        $response = $this->actingAs($user)->getJson('/api/v2/tasks'); // Mettez à jour le chemin avec le préfixe /api/v2
   
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => $task->name,
                 ]);
    }
    
    public function test_store_creates_new_task()
    {
        $user = User::factory()->create();
        $taskData = Task::factory()->raw();
    
        $response = $this->actingAs($user)->postJson('/api/v2/tasks', $taskData); // Mettez à jour le chemin avec le préfixe /api/v2
    
        $response->assertStatus(201)
                 ->assertJsonFragment($taskData);
    
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_show_returns_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson("/api/v2/tasks/{$task->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => $task->name,
                 ]);
    }

    public function test_update_updates_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $updatedData = ['name' => 'Updated Task Name'];

        $response = $this->actingAs($user)->putJson("/api/v2/tasks/{$task->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('tasks', $updatedData);
    }

    public function test_destroy_deletes_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson("/api/v2/tasks/{$task->id}");

        $response->assertStatus(204);
        
        $this->assertDeleted($task);
    }
}
