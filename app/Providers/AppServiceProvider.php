<?php

namespace App\Providers;

use App\Models\ExternalLink;
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
            $external_links = ExternalLink::query()->orderBy('ordered')->get();
            view()->share('external_links', $external_links);
    }
}
