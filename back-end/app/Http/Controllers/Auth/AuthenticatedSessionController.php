<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = User::find(Auth::user()->id);

        if ($user->is_blocked) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            throw ValidationException::withMessages([
                'email' => __('Utilisateur est blocker'),
            ]);
        }

        $user->update(['last_activity' => now(), 'status' => 'Online']);
        return response()->json([
            'message' => 'Login successful',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        User::find(Auth::user()->id)->update(['status' => 'Offline']);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();



        return response()->json([
            'message' => 'Logout successful',
            'iconColor' => "red"
        ]);
    }
}
