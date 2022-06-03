<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFamilyOfPrisonersColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('family_of_prisoners')->default(0)->after('dob');
            $table->boolean('injured_people')->default(0)->after('family_of_prisoners');
            $table->boolean('family_of_martyrs')->default(0)->after('injured_people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('family_of_prisoners');
            $table->dropColumn('injured_people');
            $table->dropColumn('family_of_martyrs');
        });
    }
}
