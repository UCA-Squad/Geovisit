<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfesseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professeurs', function(Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->foreign('id')
                    ->references('userable_id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('professeurs', function(Blueprint $table) {
            $table->dropForeign(['id']);
        });
        
        Schema::dropIfExists('professeurs');
    }
}
