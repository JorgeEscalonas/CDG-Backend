<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login de usuario
     */
    public function login(\App\Http\Requests\API\LoginRequest $request): JsonResponse
    {
        $identifier = $request->nombreU ?? $request->email;
        $password = $request->contrasena ?? $request->password;

        $user = User::where('nombreU', $identifier)->first();

        $passwordValid = false;

        if ($user) {
            if (password_get_info($user->contrasena)['algoName'] === 'bcrypt') {
                $passwordValid = Hash::check($password, $user->contrasena);
            } else {
                $passwordValid = $user->contrasena === $password;

                if ($passwordValid) {
                    $user->contrasena = Hash::make($password);
                    $user->save();
                }
            }
        }

        if (! $user || ! $passwordValid) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'data' => [
                'user' => (new UserResource($user))->resolve(),
                'token' => $token,
            ],
        ]);
    }

    /**
     * Logout de usuario
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout exitoso'
        ]);
    }

    /**
     * Obtener usuario autenticado
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => (new UserResource($request->user()))->resolve(),
        ]);
    }
}

