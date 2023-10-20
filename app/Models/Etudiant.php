<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model {

	protected $table = 'etudiants';
	public $timestamps = true;
	public static $rules = [
     //		'username.*' =>[
     //        'unique:users,username' => 'Chaque étudiant doit avoir un numéro unique!',
     //		'required_with:nom.*,prenom.*,email.*' => 'Le champ numéro étudiant est obligatoire!',
     //		'max:255' =>'Le champ numéro étudiant ne doit pas dépasser 255 caractères!'
     //    ],
     'username.*' => 'required_with:nom.*,prenom.*,email.*|max:255|unique:users,username',
     'nom.*'=> 'required_with:username.*,prenom.*,email.*|max:100',
     'prenom.*'=> 'required_with:nom.*,username.*,email.*|max:100',
     'email.*'=> 'required_with:nom.*,prenom.*,username.*|email|max:255|unique:users,email',
 ];
//	public static $messages =array(
//    'email.*' => [
//        'unique' => 'chaque étudiant doit avoir une adresse',
//    ]
//);
	public function user()
	{
		return $this->morphOne(\App\Models\User::class, 'userable');
	}

	public function classes()
	{
		return $this->belongsToMany(\App\Models\Classe::class,'classe_etudiant','etudiant_id','classe_id');
	}

}