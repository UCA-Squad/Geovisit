<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Session;
use Hash;
use Request;
use Validator;
use File;
use App\Http\Controllers\Controller;

class ProfilController extends Controller {
    protected $_niceNames = ['username' => 'login', 'password' => 'mot de passe', 'new_password' => 'nouveau mot de passe', 'new_password_confirmaion' => 'la confirmation du mot de passe', 'prenom' => 'prénom'];

    public function user() {
        return Auth::user();
        
    }

    public function showProfil() {
        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'profil');
        } else {
            Session::put('rubrique', 'profil');
        }

        $rubrique = Session::get('rubrique');
        //SI PHOTO NULL : REMPLACEMENT DANS LA VUE PAR ICONE AVATAR
        //$photo = NULL;
        //TABLEAU ENVOYE A LA VUE EN ATTENDANT APPELS MODELES
        $fichiers = [];
        if (File::exists('img/uploads/' . Auth::user()->userable_id)) {
            if (File::exists('img/uploads/' . Auth::user()->userable_id . '/img_editeur')) {
                $fichiers = File::allFiles('img/uploads/' . Auth::user()->userable_id . '/img_editeur');
            }
            if (File::exists('img/uploads/' . Auth::user()->userable_id . '/img_qcm')) {
                array_merge($fichiers, File::allFiles('img/uploads/' . Auth::user()->userable_id . '/img_qcm'));
            }
            if (File::exists('img/uploads/' . Auth::user()->userable_id . '/vid_editeur')) {
                array_merge($fichiers, File::allFiles('img/uploads/' . Auth::user()->userable_id . '/vid_editeur'));
            }
            if (File::exists('img/uploads/' . Auth::user()->userable_id . '/vid_qcm')) {
                array_merge($fichiers, File::allFiles('img/uploads/' . Auth::user()->userable_id . '/vid_qcm'));
            }
            if (!File::exists('img/uploads/' . Auth::user()->userable_id . '/thumbnails')) {
                File::makeDirectory('img/uploads/' . Auth::user()->userable_id . '/thumbnails');
            }
        } else {
            $fichiers = [];
        }
        $info = ['avatar_url' => $this->user()->avatar, 'nom' => $this->user()->nom, 'prenom' => $this->user()->prenom, 'email' => $this->user()->email, 'username' => $this->user()->username, 'id' => $this->user()->userable_id, 'tpns' => $this->user()->userable->tpns()->count(), 'classes' => $this->user()->userable->classes()->count(), 'exercices' => $this->user()->exercices()->count(), 'uri' => Request::path(), 'nbfichier' => is_countable($fichiers) ? count($fichiers) : 0];
        return view('admin/profil')->with($info);
    }

    public function updateinfoProfil() {
        $validator = Validator::make(Request::all(), [
                    'nom' => 'required|max:255',
                    'prenom' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $this->user()->userable_id . ',userable_id'
        ]);

        $validator->setAttributeNames($this->_niceNames);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $this->user()->nom = Request::input('nom');
        $this->user()->prenom = Request::input('prenom');
        $this->user()->email = Request::input('email');
        $this->user()->save();

        return redirect()->back()
                        ->withSuccessprofil('Vos informations sont bien modifiées!');
    }

    public function updateinfoConnexion() {

        if (Request::input('modif') == 'username') {
            $validation = Validator::make(Request::all(), [
                        'username' => 'required|unique:users,username',
            ]);
        } else {
            $validation = Validator::make(Request::all(), [
                        'password' => 'required|hash:' . $this->user()->password,
                        'new_password' => 'required|different:password|confirmed'
            ]);
        }

        $validation->setAttributeNames($this->_niceNames);
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation->errors())->withInput();
        }
        if (Request::input('modif') == 'username') {
            $this->user()->username = Request::input('username');
        }
        if (Request::input('modif') == 'password') {
            $this->user()->password = Hash::make(Request::input('new_password'));
        }
        $this->user()->save();

        return redirect()->back()
                        ->withSuccess('Vos informations de connexion sont bien modifiées!');
    }

}

?>