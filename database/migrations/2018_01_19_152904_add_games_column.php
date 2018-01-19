<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGamesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('games', function (Blueprint $table) {
            $table->unsignedInteger('gold_team_id')->nullable();
            $table->unsignedInteger('silver_team_id')->nullable();
            $table->unsignedInteger('bronze_team_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('gold_team_id');
            $table->dropColumn('silver_team_id');
            $table->dropColumn('bronze_team_id');
        });
    }
}
