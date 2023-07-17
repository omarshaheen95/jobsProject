<?php

namespace Database\Seeders\Lottery;

use App\Models\Lottery\LotteryGovernorate;
use Illuminate\Database\Seeder;

class LotteryGovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $governorates = [
            'بغداد',
            'نينوى',
            'البصرة',
            'السليمانية',
            'ذي قار',
            'بابل',
            'أربيل',
            'الأنبار',
            'ديالى',
            'كركوك',
            'صلاح الدين',
            'النجف',
            'واسط',
            'كربلاء',
            'القادسية',
            'دهوك',
            'ميسان',
            'المثنى',
        ];

        foreach ($governorates as $governorate)
        {
            LotteryGovernorate::query()->firstOrCreate([
                'name' => $governorate
            ],[
                'name' => $governorate
            ]);

        }
    }
}
