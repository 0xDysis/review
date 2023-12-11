<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authorizationHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);

        // Check if the token is present
        if (!$token) {
            return response()->json(['message' => 'Bearer token is required'], 401);
        }

        // Use Laravel Passport's middleware to validate the token
        return app(\Laravel\Passport\Http\Middleware\CheckClientCredentials::class)->handle($request, function ($request) use ($next) {
            return $next($request);
        });
    }
}




