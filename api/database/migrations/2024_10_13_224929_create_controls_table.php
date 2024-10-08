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
        Schema::create('controls', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('domain_id')->index('domain_id');
            $table->string('identifier', 50);
            $table->string('name');
            $table->text('description')->nullable();
            $table->tinyInteger('weight')->nullable();
            $table->text('methods')->nullable();
            $table->enum('pptdf_applicability', ['People', 'Process', 'Technology', 'Data', 'Facility'])->nullable();
            $table->enum('nist_csf_function_grouping', ['Govern', 'Identify', 'Protect', 'Detect', 'Respond', 'Recover'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controls');
    }
};
