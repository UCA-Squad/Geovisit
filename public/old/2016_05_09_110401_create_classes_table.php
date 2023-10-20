<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClassesTable extends Migration {

	public function up()
	{
		Schema::create('classes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('titre', 255);
			$table->integer('professeur_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('classes');
	}
}