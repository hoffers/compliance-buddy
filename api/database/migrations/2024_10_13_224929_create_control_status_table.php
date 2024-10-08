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
        Schema::create('control_status', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('control_id')->nullable()->index('control_id');
            $table->enum('status', ['pending', 'complete', 'in_progress'])->nullable();
            $table->integer('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_status');
    }
};
