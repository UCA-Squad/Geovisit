<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistique extends Model {

	protected $table = 'statistiques';
	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo(\App\Models\User::class);
	}

}