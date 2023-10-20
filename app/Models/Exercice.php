<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Exercice extends Model {

	protected $table = 'exercices';
	public $timestamps = true;
	protected $fillable = ['titre', 'soustitre', 'texte'];

    public function atelier_tpn()
    {
        return $this->belongsTo('App\Models\Atelier_tpn');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user', 'userable_id');
    }

    public function isDone($userable_id) {
        return DB::table('exercice_user')
                ->where(['user_id' => $userable_id, 'exercice_id' => $this->id])
                ->count();
    }

}