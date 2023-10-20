<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatistiquesTable extends Migration {

	public function up()
	{
		Schema::create('statistiques', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('etudiant_id')->unsigned();
			$table->enum('type', array('tpns', 'atelier', 'exerice'));
			$table->integer('type_visite_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('statistiques');
	}
}