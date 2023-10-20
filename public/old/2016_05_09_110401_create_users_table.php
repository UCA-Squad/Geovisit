<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('username', 255)->unique();
			$table->string('email', 255)->unique();
			$table->string('nom', 30);
			$table->string('prenom');
			$table->string('userable_type', 100);
			$table->string('password', 255);
			$table->string('remember_token', 100)->nullable();
			$table->integer('userable_id');
			$table->boolean('is_admin')->default(false);
			$table->string('avatar', 255)->nullable();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}