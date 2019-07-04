<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

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
        if ($request->route('id')) {
            $user = User::find($request->route('id'));
            if ($user && $user->id != auth()->user()->id) {
                $request->session()->flash('message-warning', 'Access not granted.');
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
