<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atelier_tpn extends Model {

	protected $table = 'atelier_tpn';
	public $timestamps = false;
	protected $fillable = ['titre_atelier'];

	public function exercices()
	{
		return $this->hasMany(\App\Models\Exercice::class);
	}

}