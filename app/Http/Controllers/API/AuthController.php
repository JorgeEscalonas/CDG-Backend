<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login de usuario
     */
    public function login(\App\Http\Requests\API\LoginRequest $request): JsonResponse
    {
        $user = User::where('nombreU', $request->nombreU)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        // Verificar contraseña (puede estar hasheada o en texto plano)
        $passwordValid = false;
        
        // Si la contraseña está hasheada, usar Hash::check
        if (password_get_info($user->contrasena)['algoName'] === 'bcrypt') {
            $passwordValid = Hash::check($request->contrasena, $user->contrasena);
        } else {
            // Si no está hasheada, comparar directamente (para migración)
            $passwordValid = $user->contrasena === $request->contrasena;
            
            // Si la contraseña es correcta pero no está hasheada, hashearla ahora
            if ($passwordValid) {
                $user->contrasena = Hash::make($request->contrasena);
                $user->save();
            }
        }

        if (!$passwordValid) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login exitoso',
            'data' => [
                'user' => [
                    'id' => $user->idUsuario,
                    'nombre' => $user->nombreU
                ],
                'token' => $token
            ]
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
            'data' => [
                'id' => $request->user()->idUsuario,
                'nombre' => $request->user()->nombreU
            ]
        ]);
    }
}

