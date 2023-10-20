<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classe;
use App\Models\User;
use App\Models\Etudiant;

class ClassesTableSeeder extends Seeder {

    public function run() {
        
        $grp1 = Classe::create(array(
            'titre' => 'GROUPE DE TP NUMERO 1',
            'professeur_id' => User::where('username', '=', 'admin_01')->get()[0]->userable_id
        ));
        
        foreach (['etudiant_01', 'etudiant_02', 'etudiant_03', 'etudiant_04', 'etudiant_05'] as $name) {
            $etd = Etudiant::find(User::where('username', '=', $name)->get()[0]->userable_id);
            $etd->classes()->attach($grp1->id);
        }
        
        $grp2 = Classe::create(array(
            'titre' => 'GROUPE DE TP NUMERO 2',
            'professeur_id' => User::where('username', '=', 'admin_01')->get()[0]->userable_id
        ));
        
        foreach (['etudiant_06', 'etudiant_07', 'etudiant_08', 'etudiant_09', 'etudiant_10'] as $name) {
            $etd = Etudiant::find(User::where('username', '=', $name)->get()[0]->userable_id);
            $etd->classes()->attach($grp2->id);
        }
    }

}
