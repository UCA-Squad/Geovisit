<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQcmQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qcm_questions', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('qcm_id')->unsigned();
            $table->foreign('qcm_id')
                    ->references('id')
                    ->on('qcm')
                    ->onDelete('cascade');
            $table->string('titre');
            $table->text('question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qcm_questions', function(Blueprint $table) {
            $table->dropForeign(['qcm_id']);
        });
        
        Schema::dropIfExists('qcm_questions');
    }
}
