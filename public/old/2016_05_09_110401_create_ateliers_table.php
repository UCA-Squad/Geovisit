<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAteliersTable extends Migration {

	public function up()
	{
		Schema::create('ateliers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('site_id')->unsigned();
			$table->string('point_sommaire', 10);
			$table->string('point_carte', 10);
			$table->string('image', 255);
			$table->float('timeline');
		});
	}

	public function down()
	{
		Schema::drop('ateliers');
	}
}