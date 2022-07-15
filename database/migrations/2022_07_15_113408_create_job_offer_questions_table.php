<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOfferQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offer_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_offer_id');
            $table->unsignedBigInteger('question_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnDelete();
            $table->foreign('job_offer_id')->references('id')->on('job_offers')->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_offer_questions');
    }
}
