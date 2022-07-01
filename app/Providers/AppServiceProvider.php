<?php

namespace App\Providers;

use App\Models\ExternalLink;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Schema::hasTable('external_links')) {
            $external_links = ExternalLink::query()->orderBy('ordered')->get();

        } else {
            $external_links = [];
        }
        view()->share('external_links', $external_links);
    }
}
