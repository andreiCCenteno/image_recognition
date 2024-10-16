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
        $table->boolean('medium_notif')->default(false); // Notification for Medium
        $table->boolean('hard_notif')->default(false); // Notification for Hard
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('medium_notif');
        $table->dropColumn('hard_notif');
    });
}

};
