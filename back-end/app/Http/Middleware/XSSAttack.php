<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XSSAttack
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $previous = $request->all();
        $input = $request->all();
        array_walk_recursive($input, function (&$input) {
            $input = strip_tags($input);
        });
        // if(array_diff($previous, $input)){
        //     abort(401, 'XSS attack');
        // }
        $request->merge($input);
        return $next($request);
    }
}
