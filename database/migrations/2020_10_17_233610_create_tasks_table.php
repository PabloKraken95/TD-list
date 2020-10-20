<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tdlist_id')->constrained();
            $table->string('name');
            $table->string('description')->nullable();
            $table->time('aprox_duration')->nullable(); // aproximately how long it will take to finish the task
            $table->string('priority')->default('medium'); // [low, medium, high]
            $table->string('state')->default('active'); //[active, done, wip, postponed]
            $table->dateTime('expire_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
