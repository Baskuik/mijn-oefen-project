<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Als de gebruiker NIET is ingelogd OF GEEN admin is...
        if (!auth()->check() || !auth()->user()->is_admin) {
            // ...stuur ze dan terug naar de home met een foutmelding
            return redirect('/')->with('error', 'Geen toegang! Je bent geen admin.');
        }
    
        return $next($request);
    }
}
