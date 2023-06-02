<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class API_CheckUserRole
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
        /* if (Auth::user()->role == 'admin') {
            return redirect('/admin/dashbord');
        } */
        /*  $user = User::findOrFail($request->user_id);
        $role = $user->role; 

        if ($role === "admin" || $role === "superadmin") {
            return $next($request);
        } else {
            return response()->json(['message' => 'Unauthenticated.']);
        }
        */
        if (Auth::user()->role == 'admin' || Auth::user()->role === "superadmin") {
            return $next($request);
        } else {
            return response()->json(['message' => 'Unauthenticated.']);
        }
    }
}
