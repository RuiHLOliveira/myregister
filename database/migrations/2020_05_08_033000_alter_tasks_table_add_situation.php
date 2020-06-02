<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTasksTableAddSituation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function(Blueprint $table) {
            // $table->dropColumn('status'); should drop only once it deprecates and we ran a column information realocating script.
            $table->unsignedBigInteger('situation_id')->nullable();
            $table->foreign('situation_id')->references('id')->on('situations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function(Blueprint $table) {
            $table->dropColumn('situation_id');
            $table->dropForeign('situation_id');
        });
    }
}
