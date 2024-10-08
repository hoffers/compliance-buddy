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
        Schema::table('evidence', function (Blueprint $table) {
            $table->foreign(['added_by'], 'evidence_ibfk_2')->references(['id'])->on('users');
            $table->foreign(['control_id'], 'evidence_ibfk_1')->references(['id'])->on('controls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evidence', function (Blueprint $table) {
            $table->dropForeign('evidence_ibfk_2');
            $table->dropForeign('evidence_ibfk_1');
        });
    }
};
