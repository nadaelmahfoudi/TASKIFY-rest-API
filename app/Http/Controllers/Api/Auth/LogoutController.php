<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Handle user logout.
     *
     * Revokes the current access token of the authenticated user.
     *
     * @OA\Post(
     *      path="/api/auth/logout",
     *      operationId="userLogout",
     *      tags={"Authentication"},
     *      summary="User logout",
     *      description="Revokes the current access token of the authenticated user.",
     *      security={{"bearerAuth": {}}},
     *      @OA\Response(
     *          response=204,
     *          description="User logged out successfully"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Unauthenticated")
     *          )
     *      ),
     * )
     */
    public function __invoke(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->noContent();
    }
}
