<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExerciceUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercice_user', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                    ->references('userable_id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->bigInteger('exercice_id')->unsigned();
            $table->foreign('exercice_id')
                    ->references('id')
                    ->on('exercices')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exercice_user', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['exercice_id']);
        });
        
        Schema::dropIfExists('exercice_user');
    }
}
