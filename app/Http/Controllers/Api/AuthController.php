<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|min:4',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name'     => $validatedData['name'],
            'email'    => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
           'join_date' => Carbon::now()->toDateString(),
        ]);

        return response()->json([
            'response_code' => '200',
            'status'        => 'success',
            'message'       => 'Registration successful',
            'data'          => $user,
        ], 200);
    }

    /**
     * Handle login requests.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'response_code' => '401',
                'status'        => 'error',
                'message'       => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();
        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json([
            'response_code' => '200',
            'status'        => 'success',
            'message'       => 'Login successful',
            'data' => [
                'user'  => $user,
                'token' => $accessToken,
            ],
        ], 200);
    }

    /**
     * Retrieve paginated user information.
     */
    public function userInfo()
    {
        try {
            $users = User::latest()->paginate(10);

            return response()->json([
                'response_code' => '200',
                'status'        => 'success',
                'message'       => 'User list retrieved successfully',
                'data' => [
                    'users' => $users->items(),
                    'pagination' => [
                        'total'        => $users->total(),
                        'per_page'     => $users->perPage(),
                        'current_page' => $users->currentPage(),
                        'last_page'    => $users->lastPage(),
                    ],
                ],
            ], 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'response_code' => '500',
                'status'        => 'error',
                'message'       => 'Failed to retrieve user list',
            ], 500);
        }
    }
}

