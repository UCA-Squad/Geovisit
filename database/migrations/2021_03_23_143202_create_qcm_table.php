<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQcmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qcm', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('exercice_id')->unsigned();
            $table->foreign('exercice_id')
                    ->references('id')
                    ->on('exercices')
                    ->onDelete('cascade');
            $table->string('titre', 255);
            $table->longText('description');
            $table->longText('description_admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qcm', function(Blueprint $table) {
            $table->dropForeign(['exercice_id']);
        });
        
        Schema::dropIfExists('qcm');
    }
}
