<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Cache\Factory;
use App\Models\Setting;
use Nette\Schema\Schema;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Factory $cache)
    {
        if (\Illuminate\Support\Facades\Schema::hasTable('settings'))
        {
            $settings = Setting::query()->get();
            $settings = $cache->remember('settings', 60, function() use ($settings){
                // Laravel >= 5.2, use 'lists' instead of 'pluck' for Laravel <= 5.1
                return $settings->pluck('value', 'key')->all();
            });
            config()->set('settings', $settings);
        }

    }
}
