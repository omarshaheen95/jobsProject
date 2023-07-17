<?php

namespace Database\Seeders\Lottery;

use App\Models\Lottery\LotteryDegree;
use Illuminate\Database\Seeder;

class LotteryDegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $degrees = [
            'دبلوم',
            'بكالوريوس',
            'دبلوم عالي',
            'ماجستير',
            'دكتوراة',
        ];

        foreach ($degrees as $degree)
        {
            LotteryDegree::query()->firstOrCreate([
                'name' => $degree
            ],[
                'name' => $degree
            ]);

        }
    }
}
