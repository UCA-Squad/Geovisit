<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use Session;
use Hash;
use Mail;


class EtudiantsController extends Controller {
    
    protected function sendMail($user, $pwd) {
        Mail::send('admin.emails.newaccount', ['user' => $user, 'password' => $pwd], function ($m) use ($user) {
            $m->from('geovisit@uca.fr', 'Géovisit');
            $m->to($user->email, $user->name)->subject('Création d\'un nouveau compte Géovisit');
        });
    }
    
    public function index() {
        
        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'etudiants');
        } else {
            Session::put('rubrique', 'etudiants');
        }
        
        if (Etudiant::count() > 0) {
            $etudiants = Etudiant::all()->sortByDesc('id');
            return view('admin.etudiants')->withNbetds(Etudiant::count())->withEtds($etudiants);
        } else {
            return view('admin.etudiants')->withNbetds(Etudiant::count());
        }
        
    }
    
    public function create(Request $request) {
        
        $validator = Validator::make($request->all(),['username' => 'required|unique:users,username', 'ine' => 'required|unique:etudiants,ine', 'nom' => 'required|max:255', 'prenom' => 'required|max:255', 'email' => 'required|email|max:255|unique:users,email']);
        
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
        $newUser->save();
        
        $newEtudiant = new Etudiant();
        $newEtudiant->id = $newUser->userable_id;
        $newEtudiant->ine = $request->input('ine');
        $newEtudiant->save();
        
        $this->sendMail($newUser, $pwd);
        
        return redirect('/admin/etudiants');
        
    }
    
    public function edit($id) {
        $etudiant = Etudiant::findOrFail($id);
        $etudiants = Etudiant::all()->sortByDesc('id');
        return view('admin.etudiants-edit')->withNbetds(Etudiant::count())->withEtds($etudiants)->withEtudiant($etudiant);
    }
    
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(),['username' => 'required|unique:users,username,' . $id . ',userable_id', 'ine' => 'required|unique:etudiants,ine,' . $id, 'nom' => 'required|max:255', 'prenom' => 'required|max:255', 'email' => 'required|email|max:255|unique:users,email,' . $id . ',userable_id']);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        
        $user = User::findOrFail($id);
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->email = $request->input('email');
        $user->username = $request->input('username');
        $user->save();
        
        $etudiant = Etudiant::findOrFail($user->userable_id);
        $etudiant->ine = $request->input('ine');
        $etudiant->save();
        
        return redirect('/admin/etudiants');
        
    }
    
    public function delete($id) {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();
        User::destroy($etudiant->id);
        return Response::json();
        
    }
    
}