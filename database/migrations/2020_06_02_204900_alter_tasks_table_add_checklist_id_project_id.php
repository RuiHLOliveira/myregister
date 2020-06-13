<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTasksTableAddChecklistIdProjectId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function(Blueprint $table) {
            $table->unsignedBigInteger('checklist_id')->nullable();
            $table->foreign('checklist_id')->references('id')->on('checklists');

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
            $table->dropForeign('taks_checklist_id_foreign');
            $table->dropColumn('checklist_id');
        });
    }
}
