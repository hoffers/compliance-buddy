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
        Schema::create('control_evidence_request', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('control_id')->index('control_id');
            $table->integer('evidence_request_id')->index('evidence_request_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_evidence_request');
    }
};
