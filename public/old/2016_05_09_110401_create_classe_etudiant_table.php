<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClasseEtudiantTable extends Migration {

	public function up()
	{
		Schema::create('classe_etudiant', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('etudiant_id')->unsigned();
			$table->integer('classe_id')->unsigned();
			$table->timestamp('timestamps');
		});
	}

	public function down()
	{
		Schema::drop('classe_etudiant');
	}
}