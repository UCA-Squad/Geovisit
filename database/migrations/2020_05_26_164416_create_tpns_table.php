<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTpnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tpns', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('professeur_id')->unsigned();
            $table->foreign('professeur_id')
                    ->references('id')
                    ->on('professeurs')
                    ->onDelete('cascade');
            $table->text('description_tpn')->nullable();
            $table->tinyInteger('publie')->default(0);
            $table->string('titre_tpns', 255);
            $table->bigInteger('site_id')->unsigned();
            $table->foreign('site_id')
                    ->references('id')
                    ->on('sites')
                    ->onDelete('cascade');
            $table->longText('contenu');
            $table->longText('contenu_admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tpns', function (Blueprint $table) {
            $table->dropForeign(['professeur_id']);
            $table->dropForeign(['site_id']);
        });
        
        Schema::dropIfExists('tpns');
    }
}
