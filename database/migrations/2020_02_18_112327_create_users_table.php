<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->bigIncrements('userable_id');
            $table->timestamps();
            $table->string('username', 255)->unique();
            $table->string('email', 255)->unique();
            $table->string('nom', 30);
            $table->string('prenom');
            $table->string('userable_type', 100)->default('App\\\Models\\\Etudiant');
            $table->string('password', 255);
            $table->string('remember_token', 100)->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('avatar')->default('/img/PROFIL_AVATAR.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
