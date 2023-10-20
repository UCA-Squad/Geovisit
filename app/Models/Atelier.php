<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atelier extends Model {

	protected $table = 'ateliers';
        
	public $timestamps = true;
        
        protected $fillable = ['site_id', 'x_sommaire', 'y_sommaire', 'x_carte', 'y_carte', 'image', 'timeline', 'image_deplie', 'lien_360', 'rayon', 'audio'];

	public function tpns()
	{
		return $this->belongsToMany(\App\Models\Tpn::class)->withPivot('description_atelier', 'titre_atelier');
	//
	}

	public function site()
	{
		return $this->belongsTo(\App\Models\Site::class);
	}

}