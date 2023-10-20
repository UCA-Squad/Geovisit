<?php

namespace App\Http\Controllers;

use Auth;
use View;
use Redirect;

class ChoixController extends Controller {

    public function index() {
        $tpnss = [];
        $user = Auth::user();
        $permission = false;
        $user_type = Auth::user()->userable;
        
        if (Auth::user()->is_admin == 1 || is_a($user_type, 'App\Models\Professeur')){
            $permission = true;
        }
        
        if (is_a($user_type, 'App\Models\Professeur') && Auth::user()->userable->tpns()->count() == 0){
            return Redirect::to('/admin');
        }
        
        if (is_a($user_type, 'App\Models\Professeur')) {
            return View::make('/choix')->withUser($user)
                            ->withPermission($permission)
                            ->withType($user_type)
                            ->withNbtpns(Auth::user()->userable->tpns->where('publie', 1)->count())
                            ->withTpns(Auth::user()->userable->tpns->where('publie', 1)->reverse());
        }

        foreach (Auth::user()->userable->classes as $classe) {
            if ($classe->tpns->where('publie', 1)->count() > 0){
                foreach ($classe->tpns->where('publie', 1)->reverse() as $k => $v){
                    $tpnss[$k] = $v;
                }
            }
        } 
        
        return View::make('/choix')->withUser($user)
                        ->withPermission($permission)
                        ->withType($user_type)
                        ->withNbtpns(count($tpnss))
                        ->withTpns($tpnss);
    }

}
