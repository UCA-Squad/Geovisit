<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSitesTable extends Migration {

	public function up()
	{
		Schema::create('sites', function(Blueprint $table) {
			$table->increments('id');
			$table->string('titre', 255);
			$table->string('photo', 255);
			$table->string('video', 255);
			$table->string('img_mini_map', 255);
			$table->string('img_sentier', 255);
		});
	}

	public function down()
	{
		Schema::drop('sites');
	}
}