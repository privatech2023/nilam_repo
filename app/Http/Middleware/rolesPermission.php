<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class rolesPermission
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
        if ($request->session()->has('admin_name') && $request->session()->get('admin_name') === 'admin') {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
