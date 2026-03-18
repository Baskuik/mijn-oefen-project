<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreviewEditMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // Altijd: als gebruiker geen admin is, forceer edit_mode uit.
        if (! auth()->check() || ! (auth()->user()->is_admin ?? false)) {
            if ($request->session()->has('edit_mode')) {
                $request->session()->forget('edit_mode');
            }
        } else {
            // Admin: toggle via ?preview=true|false (of 1/0/yes/no)
            if ($request->has('preview')) {
                if ($request->boolean('preview')) {
                    $request->session()->put('edit_mode', true);
                } else {
                    $request->session()->forget('edit_mode');
                }
            }
        }

        return $next($request);
    }
}