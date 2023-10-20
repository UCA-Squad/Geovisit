<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Etudiant;

class EtudiantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $etudiants = User::getEtudiants();
        
        $idx = 1;
        
        foreach ($etudiants as $etudiant) {
            Etudiant::create(array(
                'id' => $etudiant->userable_id,
                'ine' =>  sprintf("%05d", $idx)
            ));
            
            $idx++;
        }
    }
}
