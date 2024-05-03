<?php

namespace App\Http\Middleware;

use App\Models\Location;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class verifyLocationDate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locations = Location::where('date_fin', '<', now())->where('statut_location', 'en_cours')->get();

        foreach ($locations as $location) {
            $location->update([
                'statut_location' => 'termine',
            ]);
            $location->voiture()->update([
                'disponibilite_location' => 'disponible'
            ]);
        }

        return $next($request);
    }
}
