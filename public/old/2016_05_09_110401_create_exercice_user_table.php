<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExerciceUserTable extends Migration {

	public function up()
	{
		Schema::create('exercice_user', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('exercice_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('exercice_user');
	}
}