<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();

            $table->string('job_uuid')->nullable();
            $table->string('name');
            $table->string('slug');

            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('degree_id');

            $table->text('content')->nullable();
            $table->text('functional_terms')->nullable();
            $table->text('functional_tasks')->nullable();

            $table->enum('gender', ['male', 'female'])->nullable();
            $table->enum('family_of_prisoners', [0, 1, 2])->default(0)->comment('0: All, 1:Yes, 2:No');
            $table->enum('injured_people', [0, 1, 2])->default(0)->comment('0: All, 1:Yes, 2:No');
            $table->enum('family_of_martyrs', [0, 1, 2])->default(0)->comment('0: All, 1:Yes, 2:No');

            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->dateTime('publish_at')->nullable();

            $table->text('tags')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('position_id')->references('id')->on('positions')->cascadeOnDelete();
            $table->foreign('degree_id')->references('id')->on('degrees')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_offers');
    }
}
