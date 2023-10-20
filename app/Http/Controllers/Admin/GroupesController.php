<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use App\Models\Etudiant;
use Session;
use Illuminate\Support\Facades\Auth;
use Response;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;

class GroupesController extends Controller {

    protected $_user;
    protected $_niceNames = ['titre' => 'nom du groupe'];

    public function user() {
        return Auth::user();
    }

    public function index() {
        
        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'groupes');
        } else {
            Session::put('rubrique', 'groupes');
        }
        
        $etds = Etudiant::all();
        
        if ($this->user()->userable->classes()->count() > 0) {
            $groupes = $this->user()->userable->classes()->orderBy('id', 'DESC')->get();
            return view('admin.groupes')->withNbgroupes($this->user()->userable->classes()->count())->withGroupes($groupes)->withEtds($etds);
        }

        return view('admin.groupes')->withNbgroupes($this->user()->userable->classes()->count())->withEtds($etds);
        
    }
    
    public function create(Request $request) {
        
        $validator = Validator::make($request->all(), ['titre' => 'required|max:255|unique:classes,titre,NULL,id,professeur_id,' . $this->user()->userable_id, 'etudiants.*' => 'exists:etudiants,id']);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        
        $groupe = new Classe();
        $groupe->titre = $request->input('titre');
        $groupe->professeur_id = $this->user()->userable_id;
        $groupe->save();
        
        foreach ($request->input('etudiants') as $etd) {
            $etudiant = Etudiant::find($etd);
            $etudiant->classes()->attach($groupe->id);
        }
        
        if (Session::has('affich')) {
            Session::forget('affich');
            Session::put('affich', $groupe->id);
        } else {
            Session::put('affich', $groupe->id);
        }
        
        $etds = Etudiant::all();
        $groupes = $this->user()->userable->classes()->orderBy('id', 'DESC')->get();
        return view('admin.groupes')->withNbgroupes($this->user()->userable->classes()->count())->withGroupes($groupes)->withEtds($etds);
        
    }

    public function delete($id) {
        $groupe = Classe::findOrFail($id);
        $groupe->etudiants()->detach();        
        $groupe->delete();
        
        return Response::json(['success' => true], 200);
    }

    public function edit($id) {
        $etds = Etudiant::all();
        $groupes = $this->user()->userable->classes()->orderBy('id', 'DESC')->get();
        $groupe = Classe::findOrFail($id);
        return view('admin.groupes.edit')->with('nbgroupes', $this->user()->userable->classes()->count())->with('groupes', $groupes)->with('etds', $etds)->with('groupe_edited', $groupe);
    }

    public function update(Request $request, $id) {
        
        $validator = Validator::make($request->all(), ['titre' => 'required|max:255|unique:classes,titre,' . $id . ',id,professeur_id,' . $this->user()->userable_id, 'etudiants.*' => 'exists:etudiants,id']);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        
        $groupe = Classe::findOrFail($id);
        $groupe->titre = $request->input('titre');
        $groupe->save();
        
        foreach ($groupe->etudiants()->get() as $etudiant) {
            if (!in_array($etudiant->id, $request->input('etudiants'))) {
                $etudiant->classes()->detach($groupe->id);
            }
        }
        
        foreach ($request->input('etudiants') as $etd_id) {
            if (!$groupe->etudiants()->where('etudiants.id', $etd_id)->exists()) {
                $etd = Etudiant::find($etd_id);
                $etd->classes()->attach($groupe->id);
            }
        }
        
        $etds = Etudiant::all();
        $groupes = $this->user()->userable->classes()->orderBy('id', 'DESC')->get();
        return view('admin.groupes')->withNbgroupes($this->user()->userable->classes()->count())->withGroupes($groupes)->withEtds($etds);
    }

}