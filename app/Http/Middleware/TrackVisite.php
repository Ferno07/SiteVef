<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visite;
use Symfony\Component\HttpFoundation\Response;

class TrackVisite
{
    public function handle(Request $request, Closure $next): Response
    {
        // Ne tracker que les pages publiques GET (pas admin, pas API, pas assets)
        if ($request->isMethod('GET') && !$request->is('administrateur*', 'dashboard*', 'login*', 'register*', 'profile*', 'don/merci')) {
            $today = now()->toDateString();
            $ip    = $request->ip();

            // Une seule entrée par IP par jour (visiteur unique journalier)
            Visite::firstOrCreate(
                ['date' => $today, 'ip_address' => $ip],
                ['page' => $request->path()]
            );
        }

        return $next($request);
    }
}
