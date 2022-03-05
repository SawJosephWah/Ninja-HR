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
            $table->integer('serial_number')->nullable();
            $table->bigInteger('project_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('deadline_date')->nullable();
            $table->enum('priority',['high','middle','low']);
            $table->enum('status',['pending','in_progress','completed']);
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
