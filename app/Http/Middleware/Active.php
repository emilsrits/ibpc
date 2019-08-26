<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Active
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->status) {
            return $next($request);
        }

        if (Auth::check()) {
            Auth::logout();
        }

        flashMessage('message-warning', 'This account has been disabled!');
        return redirect('/');
    }
}
