<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLotteryGovernorateIdColumnToLotteryMinistriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lottery_ministries', function (Blueprint $table) {
            $table->unsignedBigInteger('lottery_governorate_id')->nullable()->after('code');

            $table->foreign('lottery_governorate_id')->references('id')->on('lottery_governorates')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lottery_ministries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('lottery_governorate_id');
        });
    }
}
