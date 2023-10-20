<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatlonToSites extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('sites', function(Blueprint $table) {
            $table->boolean('sig_map')->default(FALSE);
            $table->float('latmin')->nullable()->default(NULL);
            $table->float('latmax')->nullable()->default(NULL);
            $table->float('lonmin')->nullable()->default(NULL);
            $table->float('lonmax')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('sites', function(Blueprint $table) {
            $table->dropColumn('sig_map');
            $table->dropColumn('latmin');
            $table->dropColumn('latmax');
            $table->dropColumn('lonmin');
            $table->dropColumn('lonmax');
        });
    }

}
