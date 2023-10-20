<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professeur extends Model {

	protected $table = 'professeurs';
        
        protected $fillable = ['id'];
        
	public $timestamps = true;

	public function user()
	{
		return $this->morphOne(\App\Models\User::class, 'userable');
	}

	public function classes()
	{
		return $this->hasMany(\App\Models\Classe::class);
	}

	public function tpns()
	{
		return $this->hasMany(\App\Models\Tpn::class);
	}

}