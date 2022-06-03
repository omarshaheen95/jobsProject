<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_offer_id');
            $table->unsignedBigInteger('qualification_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('job_offer_id')->references('id')->on('job_offers')->cascadeOnDelete();
            $table->foreign('qualification_id')->references('id')->on('qualifications')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_qualifications');
    }
}
