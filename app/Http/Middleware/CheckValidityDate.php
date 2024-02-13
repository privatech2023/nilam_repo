<?php

namespace App\Http\Middleware;

use Closure;

class CheckValidityDate
{
    public function handle($request, Closure $next)
    {
        $currentDate = date('Y-m-d');
        $validity = $request->session()->get('validity');
        if ($validity == null || $currentDate > $validity) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
