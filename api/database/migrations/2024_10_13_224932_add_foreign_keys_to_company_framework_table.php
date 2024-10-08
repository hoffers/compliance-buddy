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
        Schema::table('company_framework', function (Blueprint $table) {
            $table->foreign(['framework_id'], 'company_framework_ibfk_2')->references(['id'])->on('frameworks');
            $table->foreign(['company_id'], 'company_framework_ibfk_1')->references(['id'])->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_framework', function (Blueprint $table) {
            $table->dropForeign('company_framework_ibfk_2');
            $table->dropForeign('company_framework_ibfk_1');
        });
    }
};
