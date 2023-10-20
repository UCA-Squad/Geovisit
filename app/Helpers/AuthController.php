<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Validator;
use View;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectPath = '/choix';
    //protected $redirectTo = '/choix';
    protected $loginPath = '/login';
   // protected $redirectIfMiddlewareBlocks = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        //$this->middleware('ajax', ['only' => 'login']);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */


    public function loginUsername()
    {
        return 'username';
    }
    protected function sendFailedLoginResponse(Request $request)
    {   /*if ($request->ajax()) {*/

        return Response::json([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ],422);
    //} else {
//return Response::json(View::make('auth.login')->withInput($request->only($this->loginUsername(), 'remember')) ->withErrors([
//               $this->loginUsername() => $this->getFailedLoginMessage(),
//            ])->render());
        //return View::make('auth.login')
        //    ->withInput($request->only($this->loginUsername(), 'remember'))
        //    ->withErrors([
        //        $this->loginUsername() => $this->getFailedLoginMessage(),
        //    ]);
        //return View::make('auth.login')
        //    ->withInput($request->only($this->loginUsername(), 'remember'))
        //    ->withErrors([
        //        $this->loginUsername() => $this->getFailedLoginMessage(),
        //    ]);
            //}
    }
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::guard($this->getGuard())->user());
        }
//return Response::json(['success' => true], 200);
               $user = Auth::user();
        $permission = false;
        //$user_type = get_class(Auth::user()->userable);
       if(Auth::user()->is_admin == 1  /* ||  is_a($user_type, 'App\models\Professeur' )*/)
            $permission = true;
       // redirect('/choix');
               $user_type = Auth::user()->userable;

       if(is_a($user_type ,'App\Models\Professeur') && Auth::user()->userable->tpns()->count() == 0)      
                 return Response::json(['redirect'=>'admin']); 

       return Response::json(['redirect'=>'choix']); 
        //return View::make('/choix')->withUser($user)
        //->withPermission($permission);
        //->withType($user_type);
    }
    //public function postLogin(Request $request)
    //{
    //    $this->validateLogin($request);
    //
    //    // If the class is using the ThrottlesLogins trait, we can automatically throttle
    //    // the login attempts for this application. We'll key this by the username and
    //    // the IP address of the client making these requests into this application.
    //    $throttles = $this->isUsingThrottlesLoginsTrait();
    //
    //    if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
    //        $this->fireLockoutEvent($request);
    //
    //        return $this->sendLockoutResponse($request);
    //    }
    //
    //    $credentials = $this->getCredentials($request);
    //
    //    if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
    //        return $this->handleUserWasAuthenticated($request, $throttles);
    //    }
    //
    //    // If the login attempt was unsuccessful we will increment the number of attempts
    //    // to login and redirect the user back to the login form. Of course, when this
    //    // user surpasses their maximum number of attempts they will get locked out.
    //    if ($throttles && ! $lockedOut) {
    //        $this->incrementLoginAttempts($request);
    //    }
    //
    //    return redirect('/login')
    //        ->withInput($request->only($this->loginUsername(), 'remember'))
    //        ->withErrors([
    //            $this->loginUsername() => $this->getFailedLoginMessage(),
    //        ]);
    //}


}
