<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtudiantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etudiants', function(Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->foreign('id')
                    ->references('userable_id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->timestamps();
            $table->string('ine', 255)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etudiants', function(Blueprint $table) {
            $table->dropForeign(['id']);
        });
        
        Schema::dropIfExists('etudiants');
    }
}
