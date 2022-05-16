<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SwitchLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Pre-Middleware Action

        if ($request->has('lang')) {
            app()->setLocale($request->get('lang'));
        } else {
            app()->setLocale('ru');
        }

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
