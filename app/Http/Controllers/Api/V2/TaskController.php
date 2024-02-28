<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * @OA\Info(
     *     title="Taskify-API",
     *     version="1.0.0",
     *     description="Description de votre API",
     *     @OA\Contact(
     *         email="elmahfoudinada17@gmail.com",
     *         name="Elmahfoudi Nada"
     *     ),
     *     @OA\License(
     *         name="Licence MIT",
     *         url="https://opensource.org/licenses/MIT"
     *     )
     * )
     */
    public function __construct(){
        $this->authorizeResource(Task::class);
    }

    /**
     * @OA\Get(
     *      path="/api/v2/tasks",
     *      operationId="getTasksList",
     *      tags={"Tasks"},
     *      summary="Get list of tasks",
     *      description="Returns list of tasks",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *      ),
     *      security={{"bearerAuth": {}}}
     * )
     */
    public function index()
    {
        return TaskResource::collection(auth()->user()->tasks()->get());
    }

    /**
     * @OA\Post(
     *      path="/api/v2/tasks",
     *      operationId="storeTask",
     *      tags={"Tasks"},
     *      summary="Create a new task",
     *      description="Creates a new task",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *      ),
     *      security={{"bearerAuth": {}}}
     * )
     */
    public function store(StoreTaskRequest $request)
    {
        $task = $request->user()->tasks()->create($request->validated());
        return TaskResource::make($task)->response()->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *      path="/api/v2/tasks/{id}",
     *      operationId="getTaskById",
     *      tags={"Tasks"},
     *      summary="Get task by ID",
     *      description="Returns a single task",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *      ),
     *      security={{"bearerAuth": {}}}
     * )
     */
    public function show(Task $task)
    {
        return TaskResource::make($task);
    }

    /**
     * @OA\Put(
     *      path="/api/v2/tasks/{id}",
     *      operationId="updateTask",
     *      tags={"Tasks"},
     *      summary="Update existing task",
     *      description="Updates an existing task",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *      ),
     *      security={{"bearerAuth": {}}}
     * )
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        return TaskResource::make($task);
    }

    /**
     * @OA\Delete(
     *      path="/api/v2/tasks/{id}",
     *      operationId="deleteTask",
     *      tags={"Tasks"},
     *      summary="Delete existing task",
     *      description="Deletes an existing task",
     *      @OA\Parameter(
     *          name="id",
     *          description="Task ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="No Content",
     *      ),
     *      security={{"bearerAuth": {}}}
     * )
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
