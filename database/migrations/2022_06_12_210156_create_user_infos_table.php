<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('full_name');
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();

            $table->enum('gender', ['male', 'female']);
            $table->date('dob')->nullable();
            $table->enum('marital_status', [1,2,3,4])->nullable()->comment('Single / Married / Divorced / Widowed');

            $table->tinyInteger('number_of_children')->default(0);
            $table->tinyInteger('number_of_employees')->default(0);
            $table->tinyInteger('scholarship_student')->default(0);
            $table->tinyInteger('top_ten_students')->default(0);



            $table->unsignedBigInteger('birth_governorate_id')->nullable();
            $table->unsignedBigInteger('governorate_id')->nullable();
            $table->string('address')->nullable();


            $table->boolean('unemployed')->default(0);
            $table->boolean('work_nonGovernmental_org')->default(0);
            $table->boolean('registered_unemployed_ministry')->default(0);

            $table->boolean('family_of_prisoners')->default(0);
            $table->boolean('injured_people')->default(0);
            $table->boolean('family_of_martyrs')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('birth_governorate_id')->references('id')->on('governorates')->cascadeOnDelete();
            $table->foreign('governorate_id')->references('id')->on('governorates')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_infos');
    }
}
