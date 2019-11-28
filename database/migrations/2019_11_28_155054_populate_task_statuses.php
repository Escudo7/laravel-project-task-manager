<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PopulateTaskStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\TaskStatus::create(['name' => 'new task']);
        \App\TaskStatus::create(['name' => 'working']);
        \App\TaskStatus::create(['name' => 'testing']);
        \App\TaskStatus::create(['name' => 'terminated']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
