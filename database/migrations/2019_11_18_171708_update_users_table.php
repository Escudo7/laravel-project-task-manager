<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('sex')->nullable();
            $table->integer('birth_year')->nullable();
            $table->integer('birth_month')->nullable();
            $table->integer('birth_day')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('firstname');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('lastname');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sex');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birth_year');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birth_month');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birth_day');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('country');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('city');
        });
    }
}
