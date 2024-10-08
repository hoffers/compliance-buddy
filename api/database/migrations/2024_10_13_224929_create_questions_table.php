<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('control_id')->index('control_id');
            $table->text('question')->nullable();
            $table->text('level_0')->nullable();
            $table->text('level_1')->nullable();
            $table->text('level_2')->nullable();
            $table->text('level_3')->nullable();
            $table->text('level_4')->nullable();
            $table->text('level_5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
