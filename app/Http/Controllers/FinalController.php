<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use View;
use Redirect;
use App\Models\Tpn;
use App\Models\Atelier;
use App\Models\Site;
use Validator;
use Response;
use hash;

class FinalController extends Controller {

    protected $_user;

    public function __construct() {
        $this->_user = Auth::user();
    }

    public function index($tpn) {
        if ($tpn == 0)
            return redirect('/logout');
        else {
            $tpn = Tpn::find($tpn);
            if ($tpn !== null)
                return view('final')->withTpn($tpn)->withUrlsite($tpn->site->dossier);
            return redirect('/');
        }
    }

    public function indexintro() {


        return view('introduction');
    }

    public function exercice() {


        return view('exercice');
    }

    public function carte($id) {
        $site = Site::find($id);
        return view('carte')->withSite($site);
    }

    public function tutoriel() {


        return view('tutoriel');
    }

    public function overlay() {


        return view('overlay');
    }

    public function show360($id, $tpn) {
        $atelier = Atelier::find($id);
        $lien = [];
        $lien = explode('/', $atelier->lien_360);
        $end = end($lien);
        array_pop($lien);
        $url = implode('/', $lien);
        array_pop($lien);
        $urlsite = implode('/', $lien);
//        return view('loyasite1')->withUrl(url('/') . $url)->withAtelier($atelier)->withId($tpn);
        return view('pannellum')->withUrl(url('/') . $url)->withAtelier($atelier)->withId($tpn);
    }

    public function profil() {
        return view('profil');
    }

    public function updateemailProfil(Request $request) {
        $validator = Validator::make($request->all(), [
                    'password' => 'required|hash:' . $this->_user->password,
                    'email' => 'required|email|max:255|unique:users,email,' . $this->_user->id
        ]);
        $this->_niceNames = ['password' => 'mot de passe'];
        $validator->setAttributeNames($this->_niceNames);
        if ($validator->fails()) {
            return Response::json([
                        'error' => $validator->errors(),
                            ], 422);
            //return redirect()->back()->withErrors()->withInput();
        }

        $this->_user->email = $request->input('email');
        $this->_user->save();

        return Response::json(['sucess' => 'Vos informations sont bien modifiées!']);
    }

    public function updatepasswordProfil(Request $request) {

        $validator = Validator::make($request->all(), [
                    'password' => 'required|hash:' . $this->_user->password,
                    'new_password' => 'required|different:password|confirmed'
        ]);
        $this->_niceNames = ['password' => 'mot de passe', 'new_password' => 'nouveau mot de passe'];
        $validator->setAttributeNames($this->_niceNames);
        if ($validator->fails()) {
            return Response::json([
                        'error' => $validator->errors(),
                            ], 422);
            //return redirect()->back()->withErrors()->withInput();
        }

        $this->_user->password = Hash::make($request->input('new_password'));
        $this->_user->save();

        return Response::json(['sucess' => 'Votre mot de passe est bien modifié!']);
    }

}
