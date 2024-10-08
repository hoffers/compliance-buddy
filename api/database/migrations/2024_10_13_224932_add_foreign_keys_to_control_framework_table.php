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
        Schema::table('control_framework', function (Blueprint $table) {
            $table->foreign(['framework_id'], 'control_framework_ibfk_2')->references(['id'])->on('frameworks');
            $table->foreign(['control_id'], 'control_framework_ibfk_1')->references(['id'])->on('controls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('control_framework', function (Blueprint $table) {
            $table->dropForeign('control_framework_ibfk_2');
            $table->dropForeign('control_framework_ibfk_1');
        });
    }
};
