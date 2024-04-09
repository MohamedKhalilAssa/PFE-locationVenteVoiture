<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Analytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class logIntoDB
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $url = $request->url();
        $referrer = $request->headers->get('referer');
        $response = $next($request);

        if ($ipAddress) {
            $route = $request->route();
            if (isset($route)) {
                $action = $route->getName();
                $existingRecord = Analytics::where('ip_address', $ipAddress)
                    ->where('action', $request->route()->getName())
                    ->whereDate('created_at', Carbon::today())
                    ->exists();
                // Check if the user has already performed the action today

                if (!$existingRecord) {

                    // Log data if the action hasn't been recorded today
                    Analytics::create([
                        'user_id' => auth()->user()->id ?? null,
                        'ip_address' => $ipAddress,
                        'user_agent' => $userAgent,
                        'url' => $url,
                        'referrer' => $referrer,
                        'action' => $action ?? 'related to Frontend',
                    ]);
                }
            }
        }

        return $response;
    }
}
