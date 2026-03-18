<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreviewEditMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // AAN: alleen admins en wanneer ?preview=true
        if ($request->boolean('preview') && auth()->check() && auth()->user()->is_admin) {
            $request->session()->put('edit_mode', true);
        }

        // UIT: wanneer ?preview=false
        if ($request->has('preview') && $request->query('preview') === 'false') {
            $request->session()->forget('edit_mode');
        }

        return $next($request);
    }
}