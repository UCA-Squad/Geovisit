<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuestionsTable extends Migration {

	public function up()
	{
		Schema::create('questions', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('exercice_id')->unsigned();
			$table->text('question')->nullable();
			$table->text('explication')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('questions');
	}
}