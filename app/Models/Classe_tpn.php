<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Etudiant;
use App\Models\Classe_etudiant;

class Classe_tpn extends Model {

	protected $table = 'classe_tpn';
	public $timestamps = true;
        
        public function getEtudiants() {
            return Etudiant::wherein('id', Classe_etudiant::select('etudiant_id')->where('classe_id', '=', $this->classe_id)->get());
        }

}