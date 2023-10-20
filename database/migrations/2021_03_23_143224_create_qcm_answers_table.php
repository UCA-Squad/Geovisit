<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQcmAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qcm_answers', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('qcm_id')->unsigned();
            $table->foreign('qcm_id')
                    ->references('id')
                    ->on('qcm')
                    ->onDelete('cascade');
            $table->bigInteger('qcm_questions_id')->unsigned();
            $table->foreign('qcm_questions_id')
                    ->references('id')
                    ->on('qcm_questions')
                    ->onDelete('cascade');
            $table->string('answer_title');
            $table->boolean('answer_boolean');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qcm_answers', function(Blueprint $table) {
            $table->dropForeign(['qcm_id']);
            $table->dropForeign(['qcm_questions_id']);
        });
        
        Schema::dropIfExists('qcm_answers');
    }
}
