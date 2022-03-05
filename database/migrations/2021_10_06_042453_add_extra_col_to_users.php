<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_id')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('nrc_number')->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender', ['male', 'feamle']);
            $table->text('address')->nullable();
            $table->bigInteger('department_id')->nullable();
            $table->date('join_of_date')->nullable();
            $table->boolean('is_present')->default(true);
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
            $table->dropColumn('employee_id');
            $table->dropColumn('phone');
            $table->dropColumn('nrc_number');
            $table->dropColumn('birthday');
            $table->dropColumn('gender');
            $table->dropColumn('address');
            $table->dropColumn('department_id');
            $table->dropColumn('join_of_date');
            $table->dropColumn('is_present');
        });
    }
}
