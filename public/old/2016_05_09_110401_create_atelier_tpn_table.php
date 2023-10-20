<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAtelierTpnTable extends Migration {

	public function up()
	{
		Schema::create('atelier_tpn', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('tpn_id')->unsigned();
			$table->integer('atelier_id')->unsigned();
			$table->text('description_atelier')->nullable();
			$table->string('titre_atelier', 255)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('atelier_tpn');
	}
}