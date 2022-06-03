<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobMinistriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_ministries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_offer_id');
            $table->unsignedBigInteger('ministry_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('job_offer_id')->references('id')->on('job_offers')->cascadeOnDelete();
            $table->foreign('ministry_id')->references('id')->on('ministries')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_ministries');
    }
}
