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
        Schema::table('control_status', function (Blueprint $table) {
            $table->foreign(['updated_by'], 'control_status_ibfk_2')->references(['id'])->on('users');
            $table->foreign(['control_id'], 'control_status_ibfk_1')->references(['id'])->on('controls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('control_status', function (Blueprint $table) {
            $table->dropForeign('control_status_ibfk_2');
            $table->dropForeign('control_status_ibfk_1');
        });
    }
};
