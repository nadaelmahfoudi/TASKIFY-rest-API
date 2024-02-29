<?php

namespace Tests\Unit\Api\v2;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class CompleteTaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test marking a task as complete in API version 2.
     *
     * @return void
     */
    public function testMarkTaskAsCompleteV2()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        // Mark the task as complete
        $response = $this->putJson("/api/V2/tasks/{$task->id}/complete", ['not_completed' => false]);

        $response->assertStatus(Response::HTTP_OK);

        // Check if the task is marked as complete in the database
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'not_completed' => false,
        ]);
    }

    /**
     * Test marking a task as not complete in API version 2.
     *
     * @return void
     */
    public function testMarkTaskAsNotCompleteV2()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id, 'not_completed' => false]);

        $this->actingAs($user);

        // Mark the task as not complete
        $response = $this->putJson("/api/V2/tasks/{$task->id}/complete", ['not_completed' => true]);

        $response->assertStatus(Response::HTTP_OK);

        // Check if the task is marked as not complete in the database
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'not_completed' => true,
        ]);
    }
}
