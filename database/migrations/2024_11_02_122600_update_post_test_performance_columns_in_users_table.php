<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePostTestPerformanceColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename existing column
            $table->renameColumn('post_test_performance', 'easy_post_test_performance');

            // Add new columns
            $table->decimal('medium_post_test_performance', 5, 2)->nullable();
            $table->decimal('hard_post_test_performance', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename column back to original
            $table->renameColumn('easy_post_test_performance', 'post_test_performance');

            // Drop the new columns
            $table->dropColumn('medium_post_test_performance');
            $table->dropColumn('hard_post_test_performance');
        });
    }
}