<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateGameStatsColumnsInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename total_games to total_wins
            $table->renameColumn('total_games', 'total_wins');
            
            // Add total_games_played column
            $table->integer('total_games_played')->default(0);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename total_wins back to total_games
            $table->renameColumn('total_wins', 'total_games');
            
            // Drop total_games_played column
            $table->dropColumn('total_games_played');
        });
    }
}