<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Session;
use App\Models\Professeur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Hash;
use Mail;

class ProfesseursController extends Controller {

    public function index() {


        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'professeur');
        } else {
            Session::put('rubrique', 'professeur');
        }
        if (Professeur::count() > 0) {
            $professeurs = Professeur::all()->sortByDesc('id');
            return view('admin.professeur')->withNbprofs(Professeur::count())->withProfs($professeurs);
        }

        return view('admin.professeur')->withNbprofs(Professeur::count());
    }

    public function destroyprof($prof_id) {
        $prof = Professeur::findOrFail($prof_id);
        $prof->delete();
        User::destroy($prof->id);
        return Response::json();
    }

    public function edit($id) {
        $prof = User::findOrFail($id);
        $professeurs = Professeur::all()->sortByDesc('id');
        return view('admin.profedit')->with('prof', $prof)->with('nbprofs', Professeur::count())->with('profs', $professeurs);
    }

    protected function envoyeremail($user, $password) {
        Mail::send('admin.emails.newaccount', ['user' => $user, 'password' => $password], function ($m) use ($user) {
            $m->from('geovisit@uca.fr', 'Géovisit');

            $m->to($user->email, $user->name)->subject('Création nouveau compte Géovisit');
        });
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
                    'username' => 'required|unique:users,username,' . $request->input('id') . ',userable_id',
                    'nom' => 'required|max:255',
                    'prenom' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $request->input('id') . ',userable_id'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        $professeur = User::where('userable_id', $request->input('id'))->firstOrFail();
        $professeur->nom = $request->input('nom');
        $professeur->prenom = $request->input('prenom');
        $professeur->email = $request->input('email');
        $professeur->username = $request->input('username');
        $professeur->save();

        return redirect('/admin/professeur');
    }

    public function create(Request $request) {
        $validator = Validator::make($request->all(), USER::$rules);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        
        $pwd = Str::random(8);
        
        $newUser = new User();
        $newUser->nom = $request->input('nom');
        $newUser->prenom = $request->input('prenom');
        $newUser->email = $request->input('email');
        $newUser->username = $request->input('username');
        $newUser->password = Hash::make($pwd);
        $newUser->userable_type = \App\Models\Professeur::class;
        $newUser->save();
        
        $prof = new Professeur();
        $prof->id = $newUser->userable_id;
        $prof->save();
        
        $this->envoyeremail($newUser, $pwd);
        return redirect('/admin/professeur');
    }

}
