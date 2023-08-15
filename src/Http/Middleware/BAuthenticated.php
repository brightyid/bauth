<?php

namespace Brighty\BAuth\Http\Middleware;

use Brighty\BAuth\Facades\BAuth;
use Closure;

class BAuthenticated
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $bearer = $request->bearerToken();

            if (!$bearer) {
                throw new \Exception('Token not found');
            }

            $bauth = BAuth::set($bearer)->user();

            $request->merge([
                'user' => $bauth->json()
            ]);

            return $next($request);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }
}
