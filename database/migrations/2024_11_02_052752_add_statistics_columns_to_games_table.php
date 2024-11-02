<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatisticsColumnsToGamesTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('total_games')->default(0);
            $table->decimal('success_rate', 5, 2)->default(0);
            $table->integer('highest_score')->default(0);
            $table->integer('post_test_performance')->default(0);
            $table->integer('ranking')->default(0);
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['total_games', 'success_rate', 'highest_score', 'post_test_performance', 'ranking']);
        });
    }
}

