<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotteries', function (Blueprint $table) {
            $table->id();
            $table->integer('selected_grade');
            $table->unsignedBigInteger('lottery_department_id');
            $table->unsignedBigInteger('lottery_ministry_id');
            $table->integer('total');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('lotteries');
    }
}
