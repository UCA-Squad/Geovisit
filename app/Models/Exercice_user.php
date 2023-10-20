<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercice_user extends Model {

	protected $table = 'exercice_user';        
	public $timestamps = true;
    protected $fillable = ['user_id', 'exercice_id'];

}