<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('average')->nullable();
            $table->string('sequencing')->nullable();
            $table->string('code')->nullable();
            $table->string('password')->nullable();
            $table->integer('graduation_year')->nullable();
            $table->unsignedBigInteger('lottery_university_id')->nullable();
            $table->unsignedBigInteger('lottery_college_id')->nullable();
            $table->unsignedBigInteger('lottery_department_id')->nullable();
            $table->unsignedBigInteger('lottery_degree_id')->nullable();
            $table->integer('selected_grade')->nullable();
            $table->string('study_type')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('gender', [1,2])->nullable()->comment('1: ذكر, 2:أنثى');
            $table->unsignedBigInteger('lottery_governorate_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('lottery_university_id')->references('id')->on('lottery_universities')->cascadeOnDelete();
            $table->foreign('lottery_college_id')->references('id')->on('lottery_colleges')->cascadeOnDelete();
            $table->foreign('lottery_department_id')->references('id')->on('lottery_departments')->cascadeOnDelete();
            $table->foreign('lottery_degree_id')->references('id')->on('lottery_degrees')->cascadeOnDelete();
            $table->foreign('lottery_governorate_id')->references('id')->on('lottery_governorates')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
