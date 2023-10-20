<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Atelier_tpn;
use App\Models\Tpn;
use App\Models\Atelier;

class Atelier_tpnTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'Paléoenvironnements du Bassin de Paris: Incursion marine du danien')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/vigny/site1/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°1',
            'titre_atelier' => 'Les roches carbonatées'
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'Paléoenvironnements du Bassin de Paris: Incursion marine du danien')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/vigny/site2/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°2',
            'titre_atelier' => 'La craie'
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'Paléoenvironnements du Bassin de Paris: Incursion marine du danien')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/vigny/site3/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°3',
            'titre_atelier' => 'Les Algues Rouges'
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'Paléoenvironnements du Bassin de Paris: Incursion marine du danien')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/vigny/site6/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°4',
            'titre_atelier' => 'Méthodologies de Terrain'
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'Paléoenvironnements du Bassin de Paris: Incursion marine du danien')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/vigny/site7/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°5',
            'titre_atelier' => 'Biodiversité du Danien'
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'Paléoenvironnements du Bassin de Paris: Incursion marine du danien')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/vigny/site8/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°6',
            'titre_atelier' => 'Platier Récifal'
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'LES ROCHES BIOGENES : Roches carbonatées')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/loya/site1/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°1',
            'titre_atelier' => 'Morphologie côtière et plateforme continentale'
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'LES ROCHES BIOGENES : Roches carbonatées')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/loya/site3/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°2',
            'titre_atelier' => 'Type de dépôts sédimentaires',
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'LES ROCHES BIOGENES : Roches carbonatées')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/loya/site5/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°3',
            'titre_atelier' => 'Sédimentations pélagique et détritique'
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'LES ROCHES BIOGENES : Roches carbonatées')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/loya/site8/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°4',
            'titre_atelier' => 'Séquences gravitaires'
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'LES ROCHES BIOGENES : Roches carbonatées')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/loya/site10/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°5',
            'titre_atelier' => 'Turbidites'
        ));
        
        Atelier_tpn::create(array(
            'tpn_id' => Tpn::where('titre_tpns', '=', 'LES ROCHES BIOGENES : Roches carbonatées')->get()[0]->id,
            'atelier_id' => Atelier::where('image_deplie', '=', '/final/tpn/loya/site13/pano.jpg')->get()[0]->id,
            'description_atelier' => 'atelier n°6',
            'titre_atelier' => 'Olistostrome'
        ));
        
    }
}
