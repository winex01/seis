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
            $table->integer('sport_managers_id')->unsigned()->nullable();
            $table->foreign('sport_managers_id')->references('id')->on('sport_managers')->onDelete('cascade');
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
            $table->dropForeign(['sport_managers_id']);
            $table->dropColumn(['sport_managers_id']);
        });
    }
}
