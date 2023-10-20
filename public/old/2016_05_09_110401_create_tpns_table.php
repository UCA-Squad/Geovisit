<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTpnsTable extends Migration {

	public function up()
	{
		Schema::create('tpns', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('professeur_id')->unsigned();
			$table->string('titre', 255)->nullable();
			$table->text('soustitre')->nullable();
			$table->text('texte')->nullable();
			$table->string('photo', 255)->nullable();
			$table->string('video', 255)->nullable();
			$table->text('description_tpn')->nullable();
			$table->boolean('publie')->default(false);
		});
	}

	public function down()
	{
		Schema::drop('tpns');
	}
}