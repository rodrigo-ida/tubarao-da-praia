<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $role2 = null)
    {
        // if (!\Auth::check() || \Auth::user()->role == \App\User::ROLE_USER || \Auth::user()->role == \App\User::ROLE_DELIVERYMAN && preg_match('/admin/', $request->route()->uri)) {
        //     return redirect()->route('login');
        // }
        //if (empty($request->user())) return redirect()->route('login');
        if ($request->user()) {

            if ($role2 != null && $request->user()->hasRole($role2) or $request->user()->hasRole($role)) {

                return $next($request);
            }
        }
        \Auth::logout();
        return redirect()->route('login')->withErros('msg', 'Você não tem permissão para acessar essa área do sistema.');
    }
}
