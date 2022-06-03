<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_qualifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('qualification_id');
            $table->unsignedBigInteger('degree_id');
            $table->unsignedBigInteger('sub_degree_id')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('appreciation_id');
            $table->string('graduation_place')->nullable();
            $table->float('average')->nullable();
            $table->date('graduation_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('qualification_id')->references('id')->on('qualifications')->cascadeOnDelete();
            $table->foreign('degree_id')->references('id')->on('degrees')->cascadeOnDelete();
            $table->foreign('sub_degree_id')->references('id')->on('sub_degrees')->cascadeOnDelete();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            $table->foreign('appreciation_id')->references('id')->on('appreciations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_qualifications');
    }
}
