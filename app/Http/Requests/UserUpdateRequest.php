<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserUpdateRequest extends Request
{

    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$id = $this->user;
		return [
			'nom' => 'required|max:255',
			'prenom' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users,email,' . $id
		];
	}

}