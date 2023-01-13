<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReturnJsonResponseMiddleware
{
    /**
     * Handle an incoming api request.
     * Make response to be returned in json.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Responses|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader !== 'application/json') {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
