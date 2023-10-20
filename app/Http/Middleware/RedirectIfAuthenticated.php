<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Response;
use Closure;
use Illuminate\Support\Facades\Auth;
use Redirect;
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next, ?string $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if(is_a(Auth::user()->userable ,'App\Models\Professeur') && Auth::user()->userable->tpns()->count() == 0)
            {
                  //  if ($request->ajax() || $request->wantsJson())
                      //  return Response::json(['redirect'=>'admin']); 
                    return  Redirect::intended('/admin/espace');
            }

            return redirect('/choix');
        }

        return $next($request);
    }
}
