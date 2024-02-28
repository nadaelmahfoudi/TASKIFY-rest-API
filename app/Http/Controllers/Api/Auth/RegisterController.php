<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Handle user registration.
     *
     * Registers a new user with the provided data and returns a token.
     *
     * @OA\Post(
     *      path="/api/auth/register",
     *      operationId="userRegister",
     *      tags={"Authentication"},
     *      summary="User registration",
     *      description="Registers a new user with the provided data and returns a token.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="User data",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="User registered successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *              @OA\Property(property="token", type="string", description="Access token"),
     *          ),
     *      ),
     * )
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->getData());
        
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('laravel_api_token')->plainTextToken
        ], 201);
    }
}
