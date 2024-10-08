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
        Schema::table('user_assignments', function (Blueprint $table) {
            $table->foreign(['assigned_by'], 'user_assignments_ibfk_2')->references(['id'])->on('users');
            $table->foreign(['user_id'], 'user_assignments_ibfk_1')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_assignments', function (Blueprint $table) {
            $table->dropForeign('user_assignments_ibfk_2');
            $table->dropForeign('user_assignments_ibfk_1');
        });
    }
};
