<?php

namespace App\Http\Middleware;

use Closure;

class Author
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

        if ($request->user() && 
           ($request->user()->is_author() || $request->user()->is_admin())) {
            return $next($request);
        }

        return redirect('/home');
    }

}
