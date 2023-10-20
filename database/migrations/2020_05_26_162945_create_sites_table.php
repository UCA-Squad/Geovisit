<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titre', 255);
            $table->string('photo', 255);
            $table->string('video', 255);
            $table->string('img_mini_map', 255)->default('');
            $table->string('img_sentier', 255)->default('');
            $table->string('dossier', 255);
            $table->string('sound', 255);
            $table->tinyInteger('sig_map')->default(FALSE);
            $table->double('latmin', null, null)->default(0.0);
            $table->double('latmax', null, null)->default(0.0);
            $table->double('lonmin', null, null)->default(0.0);
            $table->double('lonmax', null, null)->default(0.0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}
