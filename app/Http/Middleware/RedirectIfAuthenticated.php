<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // $guards = empty($guards) ? [null] : $guards;

        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {
        //         if (Auth::user()->is_admin == 1) {
        //             return redirect(RouteServiceProvider::HOME);
        //         }elseif (Auth::user()->is_dosen == 1) {
        //             return redirect(RouteServiceProvider::DOSEN);
        //         } elseif (Auth::user()->is_mahasiswa) {
        //             return redirect(RouteServiceProvider::MAHASISWA);
        //         }
        //     }
        // }

        if (Auth::check()) {
            if (Auth::user()->is_admin)  {
                return redirect(RouteServiceProvider::HOME);
            }elseif (Auth::user()->is_dosen ) {
                return redirect(RouteServiceProvider::DOSEN);
            } elseif (Auth::user()->is_mahasiswa) {
                return redirect(RouteServiceProvider::MAHASISWA);
            }
        }

        return $next($request);
    }
}
