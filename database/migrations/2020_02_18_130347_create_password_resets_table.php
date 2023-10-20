<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email');
            $table->foreign('email')
                    ->references('email')
                    ->on('users')
                    ->onDelete('cascade');
            $table->string('token');
            $table->timestamp('created_at');
            $table->index(['email', 'token']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropForeign(['email']);
        });
        
        Schema::dropIfExists('password_resets');
    }
}
