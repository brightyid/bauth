<?php

namespace Brighty\BAuth\Http\Middleware;

use Brighty\BAuth\Facades\Auth;
use Closure;

class BAuth
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

            $bauth = Auth::set($bearer)->user();
            $response = $bauth->json();

            if (!$bauth->ok()) {
                throw new \Exception($response['message']);
            }

            $request->merge([
                'user' => $response
            ]);

            return $next($request);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }
}
