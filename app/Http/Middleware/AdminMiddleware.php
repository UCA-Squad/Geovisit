<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
 * Handle an incoming request.
 *
 * @param  Request  $request
 * @return mixed
 */
public function handle($request, Closure $next)
{
    if ($request->user()->is_admin == 1 ||  is_a($request->user()->userable,'App\Models\Professeur')) {
        return $next($request);
    }
    return redirect('/');
}


}
