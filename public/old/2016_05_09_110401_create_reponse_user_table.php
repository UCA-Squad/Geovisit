<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReponseUserTable extends Migration {

	public function up()
	{
		Schema::create('reponse_user', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('reponse_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('reponse_user');
	}
}