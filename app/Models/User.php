<?php

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword; 

	protected $table = 'users';
        
    protected $primaryKey = 'userable_id';
        
	public $timestamps = true;
        
	protected $fillable = ['username', 'email', 'nom', 'prenom', 'password', 'avatar'];
        
	public static array $rules = [
        'nom' => 'required|max:255',
        'prenom' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'username' => 'required|max:255|unique:users,username'
    ];

	public function userable()
	{
		return $this->morphTo();
	}

	public function exercices()
	{
        return $this->belongsToMany('App\Models\Exercice', 'exercice_user', 'user_id');
	}

	public function reponses()
	{
        return $this->belongsToMany('App\Models\Reponse');
	}

	public function statistiques()
	{
        return $this->hasMany('App\Models\Statistique');
	}
        
        public static function getProfesseurs() {
            return DB::table('users')
                    ->select('userable_id')
                    ->where('userable_type', '=', 'App\Models\Professeur')
                    ->orderBy('userable_id', 'asc')
                    ->get();
        }
        
        public static function getEtudiants() {
            return DB::table('users')
                    ->select('userable_id')
                    ->where('userable_type', '=', 'App\Models\Etudiant')
                    ->orderBy('userable_id', 'asc')
                    ->get();
        }

}