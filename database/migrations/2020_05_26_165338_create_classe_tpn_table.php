<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasseTpnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classe_tpn', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('classe_id')->unsigned();
            $table->foreign('classe_id')
                    ->references('id')
                    ->on('classes')
                    ->onDelete('cascade');
            $table->bigInteger('tpn_id')->unsigned();
            $table->foreign('tpn_id')
                    ->references('id')
                    ->on('tpns')
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
        Schema::table('classe_tpn', function(Blueprint $table) {
            $table->dropForeign(['classe_id']);
            $table->dropForeign(['tpn_id']);
        });
        
        Schema::dropIfExists('classe_tpn');
    }
}
