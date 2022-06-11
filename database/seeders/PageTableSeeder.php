<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            ['key' => 'about_us', 'title' => 'عن النظام'],
            ['key' => 'terms_and_conditions', 'title' => 'الشروط والأحكام'],
            ['key' => 'privacy_policy', 'title' => 'سياسة الخصوصية'],
        ];

        foreach ($pages as $page)
        {
            Page::query()->firstOrCreate([
                'key' => $page['key']
            ],[
                'key' => $page['key'] ,
                'title' => $page['title']
            ]);
        }
    }
}
