<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExercicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercices', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->double('x', null, null)->default(0.0);
            $table->double('y', null, null)->default(0.0);
            $table->enum('type', ['texte', 'qcm', 'video', 'photo']);
            $table->bigInteger('atelier_tpn_id')->unsigned();
            $table->foreign('atelier_tpn_id')
                    ->references('id')
                    ->on('atelier_tpn')
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
        Schema::table('exercices', function(Blueprint $table) {
            $table->dropForeign(['atelier_tpn_id']);
        });
        
        Schema::dropIfExists('exercices');
    }
}
