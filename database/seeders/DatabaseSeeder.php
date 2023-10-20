<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
		Model::unguard();

		$this->call(UserTableSeeder::class);
        $this->call(ProfesseursTableSeeder::class);
        $this->call(EtudiantsTableSeeder::class);
        $this->call(ClassesTableSeeder::class);
		$this->command->info('User table seeded!');
        $this->call(SitesTableSeeder::class);
        $this->call(AteliersTableSeeder::class);
        $this->command->info('Site table seeded!');
        $this->call(TpnsTableSeeder::class);
        $this->call(Atelier_tpnTableSeeder::class);
        $this->call(ExercicesTableSeeder::class);
        $this->call(Classe_tpnTableSeeder::class);
	}
}