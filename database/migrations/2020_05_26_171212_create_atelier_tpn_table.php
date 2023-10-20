<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtelierTpnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atelier_tpn', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('tpn_id')->unsigned();
            $table->foreign('tpn_id')
                    ->references('id')
                    ->on('tpns')
                    ->onDelete('cascade');
            $table->bigInteger('atelier_id')->unsigned();
            $table->foreign('atelier_id')
                    ->references('id')
                    ->on('ateliers')
                    ->onDelete('cascade');
            $table->text('description_atelier');
            $table->string('titre_atelier', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('atelier_tpn', function(Blueprint $table) {
            $table->dropForeign(['tpn_id']);
            $table->dropForeign(['atelier_id']);
        });
        
        Schema::dropIfExists('atelier_tpn');
    }
}
