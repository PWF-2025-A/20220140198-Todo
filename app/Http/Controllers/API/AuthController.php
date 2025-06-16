<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth; // Added for Auth facade

class AuthController extends Controller
{
    /**
     * login user dengan email dan password.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the incoming request data
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6', // Password minimum length assumed from image
        ]);

        // Check if email or password are empty after validation (though validation should handle this)
        if (empty($data['email']) || empty($data['password'])) {
            return response()->json([
                'status_code' => 400,
                'message' => 'Email dan password harus diisi',
            ], 400);
        }

        try {
            // Attempt to authenticate the user using the 'api' guard
            if (!$token = Auth::guard('api')->attempt($data)) {
                return response()->json([
                    'status_code' => 401,
                    'message' => 'Email atau password salah',
                ], 401);
            }

            // Get the authenticated user
            $user = Auth::guard('api')->user();

            // Return a success response with user data and token
            return response()->json([
                'status_code' => 200,
                'message' => 'Login berhasil',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'is_admin' => $user->is_admin, // Ensure 'is_admin' column exists or handle it
                    ],
                    'token' => $token,
                ],
            ], 200);

        } catch (Exception $e) {
            // Catch any exceptions and return a server error response
            return response()->json([
                'status_code' => 500,
                'message' => 'Terjadi kesalahan',
            ], 500);
        }
    }

    /**
     * logout user yang sedang login.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // Logout the user from the 'api' guard
        Auth::guard('api')->logout();

        // Return a success response
        return response()->json([
            'message' => 'Logout berhasil',
        ], 200);
    }
}
