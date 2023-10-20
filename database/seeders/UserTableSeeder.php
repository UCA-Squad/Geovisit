<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder {

    public function run() {
        /* Admin */
        User::create(array(
            'username' => 'admin_01',
            'email' => 'admin_01@geovist.fr',
            'nom' => 'Administrateur',
            'prenom' => 'Numéro 01',
            'userable_type' => 'App\Models\Professeur',
            'password' => bcrypt('geovisit'),
            'is_admin' => 1
        ));
        
        /* Professeurs */
        User::create(array(
            'username' => 'professeur_01',
            'email' => 'professeur_01@geovisit.fr',
            'nom' => 'Professeur',
            'prenom' => 'Prénom 01',
            'userable_type' => 'App\Models\Professeur',
            'password' => bcrypt('professeur_01')
        ));

        User::create(array(
            'username' => 'professeur_02',
            'email' => 'professeur_02@geovisit.fr',
            'nom' => 'Professeur',
            'prenom' => 'Prénom 02',
            'userable_type' => 'App\Models\Professeur',
            'password' => bcrypt('professeur_02')
        ));

        /* Etudiants */
        User::create(array(
            'username' => 'etudiant_01',
            'email' => 'etudiant_01@geovisit.fr',
            'nom' => 'Etudiant',
            'prenom' => 'Prénom 01',
            'password' => bcrypt('etudiant_01')
        ));

        User::create(array(
            'username' => 'etudiant_02',
            'email' => 'etudiant_02@geovisit.fr',
            'nom' => 'Etudiant',
            'prenom' => 'Prénom 02',
            'password' => bcrypt('etudiant_02')
        ));

        User::create(array(
            'username' => 'etudiant_03',
            'email' => 'etudiant_03@geovisit.fr',
            'nom' => 'Etudiant',
            'prenom' => 'Prénom 03',
            'password' => bcrypt('etudiant_03')
        ));

        User::create(array(
            'username' => 'etudiant_04',
            'email' => 'etudiant_04@geovisit.fr',
            'nom' => 'Etudiant',
            'prenom' => 'Prénom 04',
            'password' => bcrypt('etudiant_04')
        ));

        User::create(array(
            'username' => 'etudiant_05',
            'email' => 'etudiant_05@geovisit.fr',
            'nom' => 'Etudiant',
            'prenom' => 'Prénom 05',
            'password' => bcrypt('etudiant_05')
        ));

        User::create(array(
            'username' => 'etudiant_06',
            'email' => 'etudiant_06@geovisit.fr',
            'nom' => 'Etudiant',
            'prenom' => 'Prénom 06',
            'password' => bcrypt('etudiant_06')
        ));

        User::create(array(
            'username' => 'etudiant_07',
            'email' => 'etudiant_07@geovisit.fr',
            'nom' => 'Etudiant',
            'prenom' => 'Prénom 07',
            'password' => bcrypt('etudiant_07')
        ));

        User::create(array(
            'username' => 'etudiant_08',
            'email' => 'etudiant_08@geovisit.fr',
            'nom' => 'Etudiant',
            'prenom' => 'Prénom 08',
            'password' => bcrypt('etudiant_08')
        ));

        User::create(array(
            'username' => 'etudiant_09',
            'email' => 'etudiant_09@geovisit.fr',
            'nom' => 'Etudiant',
            'prenom' => 'Prénom 09',
            'password' => bcrypt('etudiant_09')
        ));

        User::create(array(
            'username' => 'etudiant_10',
            'email' => 'etudiant_10@geovisit.fr',
            'nom' => 'Etudiant',
            'prenom' => 'Prénom 10',
            'password' => bcrypt('etudiant_10')
        ));
    }

}
