<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            User::find(Auth::user()->id)->update(['last_activity' => now(), 'status' => 'Online']);
        }
        User::where('last_activity', '<', now()->subMinutes(120))->update(['status' => 'Offline']);
        return $next($request);
    }
}
