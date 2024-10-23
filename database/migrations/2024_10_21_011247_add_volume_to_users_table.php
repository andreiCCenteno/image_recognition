<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->integer('music_volume')->default(50); // Default to 50%
        $table->integer('sfx_volume')->default(50); // Default to 50%
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('music_volume');
        $table->dropColumn('sfx_volume');
    });
}
};
