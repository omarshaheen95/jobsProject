<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Factory $cache)
    {
        $settings = [
            ['name' => 'Website Name', 'key' => 'NAME', 'value' => null, 'type' => 'text'],
            ['name' => 'Mobile', 'key' => 'MOBILE', 'value' => null, 'type' => 'text'],
            ['name' => 'Twitter url', 'key' => 'TWITTER_URL', 'value' => null, 'type' => 'text'],
            ['name' => 'Instagram url', 'key' => 'INSTAGRAM_URL', 'value' => null, 'type' => 'text'],
            ['name' => 'Facebook url', 'key' => 'FACEBOOK_URL', 'value' => null, 'type' => 'text'],
            ['name' => 'Linked in', 'key' => 'LINKEDIN', 'value' => null, 'type' => 'text'],
            ['name' => 'Youtube', 'key' => 'YOUTUBE', 'value' => null, 'type' => 'text'],
            ['name' => 'Introduction', 'key' => 'INTRODUCTION', 'value' => null, 'type' => 'textarea'],
        ];

        foreach($settings as $setting)
        {
            $sets = Setting::query()->firstOrCreate([
                'key' => $setting['key'],
            ],
                $setting
            );
        }

        $settings = Setting::query();

        $settings = $cache->remember('settings', 60, function() use ($settings){
            // Laravel >= 5.2, use 'lists' instead of 'pluck' for Laravel <= 5.1
            return $settings->get('value', 'key')->toArray();
        });
        config()->set('settings', $settings);
    }
}
