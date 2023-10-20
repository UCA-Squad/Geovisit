<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe_tpn;
use App\Models\Classe;
use App\Models\Tpn;

class Classe_tpnTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classe_tpn::create(array(
            'classe_id' => Classe::where('titre', 'GROUPE DE TP NUMERO 1')->get()[0]->id,
            'tpn_id' => Tpn::where('titre_tpns', 'Paléoenvironnements du Bassin de Paris: Incursion marine du danien')->get()[0]->id
        ));
    }
}
