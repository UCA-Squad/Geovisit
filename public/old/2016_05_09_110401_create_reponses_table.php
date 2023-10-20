<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReponsesTable extends Migration {

	public function up()
	{
		Schema::create('reponses', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('question_id')->unsigned();
			$table->boolean('reponse')->default(false);
			$table->text('libelle_reponse')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('reponses');
	}
}