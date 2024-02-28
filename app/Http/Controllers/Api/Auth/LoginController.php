<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Handle user login.
     *
     * Authenticates a user with the provided credentials and returns a token.
     *
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="userLogin",
     *      tags={"Authentication"},
     *      summary="User login",
     *      description="Authenticates a user with the provided credentials and returns a token.",
     *      @OA\RequestBody(
     *          required=true,
     *          description="User credentials",
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password123"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User authenticated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *              @OA\Property(property="token", type="string", description="Access token"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid credentials",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Your Data is incorrect!")
     *          )
     *      ),
     * )
     */
    public function __invoke(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password , $user->password)){
            throw ValidationException::withMessages([
                'email' => ['Your Data is incorrect !']
            ]);
        }

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('laravel_api_token')->plainTextToken
        ]);
    }
}
