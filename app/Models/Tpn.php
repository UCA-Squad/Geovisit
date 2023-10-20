<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Atelier_tpn;
use App\Models\Classe_tpn;
use App\Models\Site;

class Tpn extends Model {

	protected $table = 'tpns';
	public $timestamps = true;
	protected $fillable = ['titre', 'soustitre', 'texte'];

	public function professeur()
	{
		return $this->belongsTo(\App\Models\Professeur::class);
	}

	public function ateliers()
	{
            return $this->belongsToMany(\App\Models\Atelier::class)->withPivot('description_atelier', 'titre_atelier','id');
                
	}
        
        public function getAteliersTpn() {
            return Atelier_tpn::where('tpn_id', $this->id)->get();
        }

	public function classes()
	{
		return $this->belongsToMany(\App\Models\Classe::class);
	}
        
        public function getClasses() {
            return Classe_tpn::where('tpn_id', $this->id)->get();
        }
        
        
	public function site()
	{
		return $this->belongsTo(\App\Models\Site::class);
	}

}