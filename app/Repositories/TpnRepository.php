<?php

namespace App\Repositories;

use App\Models\Tpn;

class TpnRepository
{

    protected $tpn;

  

	private function save(Tpn $tpn, Array $inputs)
	{
		$tpn->professeur_id = $inputs['id_professeur'];
		$tpn->titre = $inputs['titre_tpn'];	
		$tpn->publie = isset($inputs['publie']);	
		$tpn->description_tpn = $inputs['description'];
		$tpn->save();
	}

	

}