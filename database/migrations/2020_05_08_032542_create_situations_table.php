<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSituationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('situations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('situation');
            $table->integer('order')->default(1);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

        });

        DB::table('situations')->insert([
            ['id' => 1, 'situation' => 'Tickler'],
            ['id' => 2, 'situation' => 'Waiting For'],
            ['id' => 3, 'situation' => 'Recurring'],
            ['id' => 4, 'situation' => 'Next'],
            ['id' => 5, 'situation' => 'Read List'],
            ['id' => 6, 'situation' => 'Someday/Maybe'],
            ['id' => 7, 'situation' => 'Project']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('situations');
    }
}
