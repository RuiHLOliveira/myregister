<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->longText('name');
            $table->longText('description')->nullable();
            $table->dateTime('duedate', 0)->nullable();
            $table->boolean('completed')->default(false);
            $table->unsignedBigInteger('situation_id')->nullable();
            $table->unsignedBigInteger('checklist_id')->nullable();
            $table->unsignedBigInteger('project_id', 0)->nullable();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('situation_id')->references('id')->on('situations');
            $table->foreign('project_id')->references('id')->on('projects');
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
        Schema::dropIfExists('tasks');
    }
}
