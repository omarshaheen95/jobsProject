<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLotteryMinistryIdColumnToLotteryDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lottery_departments', function (Blueprint $table) {
            $table->unsignedBigInteger('lottery_ministry_id')->nullable()->after('governor');

            $table->foreign('lottery_ministry_id')->on('lottery_ministries')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lottery_departments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('lottery_ministry_id');
        });
    }
}
