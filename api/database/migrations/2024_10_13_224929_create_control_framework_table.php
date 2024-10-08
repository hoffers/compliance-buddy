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
        Schema::create('control_framework', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('control_id')->index('control_id');
            $table->integer('framework_id')->index('framework_id');
            $table->json('framework_references')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_framework');
    }
};
