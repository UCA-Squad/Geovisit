<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExercicesTable extends Migration {

	public function up()
	{
		Schema::create('exercices', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('point', 30)->nullable();
			$table->enum('type', array('texte', 'qcm', 'video', 'photo'));
			$table->integer('atelier_tpn_id')->unsigned();
			$table->string('titre', 255)->nullable();
			$table->text('soustitre')->nullable();
			$table->string('photo', 255)->nullable();
			$table->string('video', 255)->nullable();
			$table->text('texte')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('exercices');
	}
}