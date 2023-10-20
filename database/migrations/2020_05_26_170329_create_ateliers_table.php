<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAteliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ateliers', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('site_id')->unsigned();
            $table->foreign('site_id')
                    ->references('id')
                    ->on('sites')
                    ->onDelete('cascade');
            $table->double('x_sommaire', null, null)->default(0.0);
            $table->double('y_sommaire', null, null)->default(0.0);
            $table->double('x_carte', null, null)->default(0.0);
            $table->double('y_carte', null, null)->default(0.0);
            $table->string('image', 255);
            $table->double('timeline', null, null);
            $table->string('image_deplie', 255);
            $table->string('lien_360', 255)->default('');
            $table->double('rayon', null, null)->default(40);
            $table->double('vmin', null, null);
            $table->double('vmax', null, null);
            $table->double('hmin', null, null)->default(-180.0);
            $table->double('hmax', null, null)->default(180.0);
            $table->string('audio', 255);
            $table->double('haov', null, null)->default(360);
            $table->double('vaov', null, null)->default(180);
            $table->double('vOffset', null, null)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ateliers', function(Blueprint $table) {
            $table->dropForeign(['site_id']);
        });
        
        Schema::dropIfExists('ateliers');
    }
}
