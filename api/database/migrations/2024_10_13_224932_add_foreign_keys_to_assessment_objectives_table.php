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
        Schema::table('assessment_objectives', function (Blueprint $table) {
            $table->foreign(['control_id'], 'assessment_objectives_ibfk_1')->references(['id'])->on('controls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_objectives', function (Blueprint $table) {
            $table->dropForeign('assessment_objectives_ibfk_1');
        });
    }
};
