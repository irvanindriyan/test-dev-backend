<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\FunctionHelpers;

class OnlyJsonRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->method(), ['POST', 'PUT']) && !$request->isJson()) {
            return response()->json(
                FunctionHelpers::resError(
                    'Request must be JSON', 
                    422
                ), 
                422
            );
        }

        return $next($request);
    }
}
