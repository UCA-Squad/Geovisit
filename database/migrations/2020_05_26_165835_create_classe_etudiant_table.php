<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasseEtudiantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classe_etudiant', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('classe_id')->unsigned();
            $table->foreign('classe_id')
                    ->references('id')
                    ->on('classes')
                    ->onDelete('cascade');
            $table->bigInteger('etudiant_id')->unsigned();
            $table->foreign('etudiant_id')
                    ->references('id')
                    ->on('etudiants')
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
        Schema::table('classe_etudiant', function(Blueprint $table) {
            $table->dropForeign(['classe_id']);
            $table->dropForeign(['etudiant_id']);
        });
        
        Schema::dropIfExists('classe_etudiant');
    }
}