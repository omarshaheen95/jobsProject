<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lottery_degree_id');
            $table->unsignedBigInteger('lottery_university_id')->nullable();
            $table->unsignedBigInteger('lottery_college_id')->nullable();
            $table->unsignedBigInteger('lottery_department_id')->nullable();
            $table->unsignedBigInteger('lottery_ministry_id')->nullable();
            $table->unsignedBigInteger('lottery_position_id')->nullable();
            $table->integer('total_required')->default(0);
            $table->integer('grade_required')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lottery_degree_id')->references('id')->on('lottery_degrees')->cascadeOnDelete();
            $table->foreign('lottery_position_id')->references('id')->on('lottery_positions')->cascadeOnDelete();
            $table->foreign('lottery_university_id')->references('id')->on('lottery_universities')->cascadeOnDelete();
            $table->foreign('lottery_college_id')->references('id')->on('lottery_colleges')->cascadeOnDelete();
            $table->foreign('lottery_department_id')->references('id')->on('lottery_departments')->cascadeOnDelete();
            $table->foreign('lottery_ministry_id')->references('id')->on('lottery_ministries')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
