<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClasseTpnTable extends Migration {

	public function up()
	{
		Schema::create('classe_tpn', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('classe_id')->unsigned();
			$table->integer('tpn_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('classe_tpn');
	}
}