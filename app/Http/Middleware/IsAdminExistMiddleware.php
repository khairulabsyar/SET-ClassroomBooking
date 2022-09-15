<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminExistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // to check 'isAdmin' key eist in request
        $keyExist = $request->has('isAdmin');

        if ($keyExist) {
            // fetch the value of 'isAdmin'
            $valid = $request->input('isAdmin');

            if ($valid) {
                // proceed request to next middleware
                return $next($request);
            }
        }

        // if all not pass, about 403
        abort(403, 'Not Admin');
    }
}