<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Professeur;

class ProfesseursTableSeeder extends Seeder {
    
    public function run() {
        
        $Profs = User::getProfesseurs();
        
        foreach ($Profs as $prof) {
            Professeur::create(array(
                'id' => $prof->userable_id
            ));
        }
    }
    
}
