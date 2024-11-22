<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->firstOrFail();
        $user->load('photo');

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('YourAppName')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => new UserResource($user)
            ]);
        } else {
            throw ValidationException::withMessages([
                'error' => 'Ошибка аутентификации'
            ]);
        }
    }

    public function user(Request $request): UserResource
    {
        $user = Auth::user();
        $user->load('photo');
        return new UserResource($user);
    }

    public function logout(Request $request): JsonResponse
    {
        // Отзыв токена при выходе
        Auth::user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
