<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetEditMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->query('preview') === 'true'
            && auth()->check()
            && auth()->user()->is_admin
        ) {
            session(['edit_mode' => true]);
        }

        if ($request->query('exit_preview') === 'true') {
            session()->forget('edit_mode');
        }

        return $next($request);
    }
}