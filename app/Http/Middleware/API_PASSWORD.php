<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class API_PASSWORD
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
        if ($request->input('api_password') !== env('API_PASSWORD', 'fdwfeasdfewfsafwef23243f43')) {
            return response()->json(['message' => 'Unauthenticated.']);
        }
        if ($request->method() === 'DELETE') {
            // Check if API token matches the expected value
            $apiPassword = $request->input('api_password');
            if ($apiPassword !== env('API_PASSWORD', 'fdwfeasdfewfsafwef23243f43')) {
                return response()->json(['message' => 'Something wrong.'], 400);
            }
        }
        return $next($request);
    }
}
