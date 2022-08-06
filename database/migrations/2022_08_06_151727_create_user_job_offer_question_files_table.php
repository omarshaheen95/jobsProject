<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJobOfferQuestionFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_job_offer_question_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_job_offer_id');
            $table->unsignedBigInteger('question_id');
            $table->string('file')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_job_offer_id')->references('id')->on('user_job_offers')->cascadeOnDelete();
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_job_offer_question_files');
    }
}
