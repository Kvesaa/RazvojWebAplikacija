<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @group Authentication
 * 
 * APIs for handling authentication including Google OAuth2 and token management.
 */
class AuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     * 
     * Redirects the user to Google's OAuth consent screen.
     * 
     * @response 302
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     * 
     * Handles the callback from Google OAuth and creates or logs in the user.
     * 
     * @response 302
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if ($user) {
                // User exists, log them in
                Auth::login($user);
            } else {
                // Create new user with reader role by default
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(16)), // Random password since they'll use OAuth
                    'email_verified_at' => now(),
                ]);
                
                // Assign reader role by default
                $user->assignRole('reader');
                
                Auth::login($user);
            }
            
            // Redirect to frontend with success message
            return redirect('/?login=success');
            
        } catch (\Exception $e) {
            return redirect('/?login=error');
        }
    }

    /**
     * Create Sanctum token from credentials
     * 
     * Creates a Sanctum personal access token using email/password credentials.
     * 
     * @bodyParam email string required User email address. Example: admin@example.com
     * @bodyParam password string required User password. Example: password
     * @bodyParam device_name string required Device name for the token. Example: dev
     * 
     * @response 200 {
     *   "token": "1|abc123def456..."
     * }
     * 
     * @response 401 {
     *   "message": "Invalid credentials"
     * }
     */
    public function issueToken(Request $request)
    {
        // If user is already authenticated (e.g., via session), use that user
        if (Auth::check()) {
            $user = Auth::user();
            $deviceName = $request->input('device_name', 'api-token');
            $token = $user->createToken($deviceName)->plainTextToken;
            return response()->json(['token' => $token]);
        }

        // Otherwise, authenticate with email/password
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Revoke current token
     * 
     * Revokes the current Sanctum token.
     * 
     * @response 200 {
     *   "message": "Token revoked successfully"
     * }
     */
    public function revokeToken(Request $request)
    {
        $user = $request->user();
        if (!$user || !$user->currentAccessToken()) {
            return response()->json(['message' => 'No active token'], 400);
        }
        $user->currentAccessToken()->delete();
        return response()->noContent(); // 204
    }
}



