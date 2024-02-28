<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class CompleteTaskController extends Controller
{
    /**
     * Mark a task as completed or not completed.
     *
     * Marks a task as completed or not completed based on the provided status.
     *
     * @OA\Put(
     *      path="/api/v2/tasks/{task}/complete",
     *      operationId="markTaskAsComplete",
     *      tags={"Tasks"},
     *      summary="Mark a task as completed or not completed",
     *      description="Marks a task as completed or not completed based on the provided status.",
     *      @OA\Parameter(
     *          name="task",
     *          description="Task ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          description="Task completion status",
     *          @OA\JsonContent(
     *              required={"not_completed"},
     *              @OA\Property(
     *                  property="not_completed",
     *                  type="boolean",
     *                  description="Indicates whether the task is not completed (false) or completed (true)."
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Task updated successfully",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Task not found"
     *      ),
     *      security={{"bearerAuth": {}}}
     * )
     */
    public function __invoke(Request $request, Task $task)
    {
        $task->not_completed = $request->not_completed;
        $task->save();

        return TaskResource::make($task);
    }
}
