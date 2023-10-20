<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Etudiant;
use App\Models\Classe_etudiant;

class Classe extends Model {

    protected $table = 'classes';
    public $timestamps = true;
    protected $fillable = ['titre', 'professeur_id'];

    public function professeur() {
        return $this->belongsTo(\App\Models\Professeur::class);
    }

    public function etudiants() {
        return $this->belongsToMany(\App\Models\Etudiant::class);
    }

    public function tpns() {
        return $this->belongsToMany(\App\Models\Tpn::class);
    }

    public function getEtudiants() {
        return Etudiant::wherein('id', Classe_etudiant::select('etudiant_id')->where('classe_id', '=', $this->id)->get());
    }

}
