<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reponse extends Model {

	protected $table = 'reponses';
	public $timestamps = true;
	protected $fillable = ['libelle_reponse'];

	public function question()
	{
		return $this->belongsTo(\App\Models\Question::class);
	}

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class);
	}

}