<?php

namespace App\Http\Middleware;

use Closure;

class Owner
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
        if ($request->route('user')) {
            $user = $request->route('user');
            if ($user && $user->id != auth()->user()->id) {
                flashMessage('message-warning', 'Access not granted.');
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
