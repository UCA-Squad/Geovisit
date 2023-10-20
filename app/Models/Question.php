<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {

	protected $table = 'questions';
	public $timestamps = true;
	protected $fillable = ['question', 'explication'];

	public function exercice()
	{
		return $this->belongsTo(\App\Models\Exercice::class);
	}

	public function reponses()
	{
		return $this->hasMany(\App\Models\Reponse::class);
	}

}