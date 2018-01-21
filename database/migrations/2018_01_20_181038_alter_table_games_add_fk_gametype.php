<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableGamesAddFkGametype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->foreign('game_type_id')->references('id')->on('game_types')->onDelete('cascade');
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
            $table->dropForeign('games_game_type_id_foreign');
        });
    }
}
