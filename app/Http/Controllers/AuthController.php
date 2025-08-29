<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required|string|in:admin,customer,dealer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
        ]);

        // Login user immediately
        $token = auth()->login($user);

        // Set same expiry as login
        $expiresInSeconds = 60 * 60 * 24 * 365; // 1 year
        $tokenExpiresAt = now()->addSeconds($expiresInSeconds);

        $user->access_token = $token;
        $user->token_expires_at = $tokenExpiresAt;
        $user->save();

        return $this->respondWithToken($token, $expiresInSeconds);
    }


    /**
     * Login
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth()->user();

        // Example: 1 year expiry
        $expiresInSeconds = 60 * 60 * 24 * 365;
        $tokenExpiresAt = now()->addSeconds($expiresInSeconds);

        $user->access_token = $token;
        $user->token_expires_at = $tokenExpiresAt;
        $user->save();

        return $this->respondWithToken($token, $expiresInSeconds);
    }

    /**
     * Change password (user must be logged in)
     */
    public function changePassword(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'password' => 'required|string|min:6|old_password|confirmed',
            'new_password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['error' => 'Old password is incorrect'], 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['message' => 'Password changed successfully']);
    }

    /**
     * Get the authenticated User
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Logout
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh token
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh(), auth()->factory()->getTTL() * (365 * 24 * 60));
    }

    /**
     * Respond with token
     */
    protected function respondWithToken($token, $expiresInSeconds)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiresInSeconds
        ]);
    }
}
