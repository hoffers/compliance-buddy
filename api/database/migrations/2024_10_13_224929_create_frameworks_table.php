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
        Schema::create('frameworks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('short_name', 100)->unique('short_name');
            $table->string('full_name');
            $table->string('source')->nullable();
            $table->string('geography', 100)->nullable();
            $table->string('version', 50)->nullable();
            $table->text('url')->nullable();
            $table->string('identifier', 100);

            $table->index(['full_name', 'version'], 'full_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frameworks');
    }
};
