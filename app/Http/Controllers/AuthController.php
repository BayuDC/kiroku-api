<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller {

    /**
     * Login user and return JWT token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $credentials = $request->only('username', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Username atau password salah'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Tidak dapat membuat token'
            ], 500);
        }

        $user = auth('api')->user();

        return response()->json([
            'message' => 'Berhasil masuk',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role' => $user->role,
            ],
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * Logout user (invalidate token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'message' => 'Berhasil keluar'
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Gagal keluar, silakan coba lagi'
            ], 500);
        }
    }

    /**
     * Get authenticated user info
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info() {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json([
                    'message' => 'Pengguna tidak ditemukan'
                ], 404);
            }
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'Token tidak valid'
            ], 401);
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role' => $user->role,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]
        ]);
    }
}
