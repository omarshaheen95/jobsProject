<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\News;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserJobOffer;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:general settings management');
    }

    public function home()
    {
        $news = News::query()->count();
        $users = User::query()->count();
        $job_offers = JobOffer::query()->count();
        $users_job_offers = UserJobOffer::query()->count();

        $users_date = User::query()->groupBy('date')->orderBy('date', 'DESC')->whereMonth('created_at', now())
            ->whereYear('created_at', now())
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as counts')
            ));
        $users_job_offers_chart = UserJobOffer::query()->groupBy('date')->orderBy('date', 'DESC')->whereMonth('created_at', now())
            ->whereYear('created_at', now())
            ->get(array(
                DB::raw('Date(created_at) as date'),
                DB::raw('COUNT(*) as counts')
            ));

        return view('manager.home', compact('news', 'users', 'job_offers', 'users_job_offers', 'users_date', 'users_job_offers_chart'));
    }

    public function viewSettings()
    {
        $title = 'الإعدادات العامة';
        $settings = Setting::query()->get();
        return view('manager.settings.general', compact('title', 'settings'));
    }

    public function settings(Request $request, Factory $cache)
    {
        $settings_data = $request->validate([
            'settings' => 'required|array',
        ]);


        foreach ($settings_data['settings'] as $key => $val) {
            $setting = Setting::query()->where('key', $key)->first();
            if ($setting) {
                $setting->update([
                    'value' => $val,
                ]);
            }
        }
        // When the settings have been updated, clear the cache for the key 'settings'
        $settings = Setting::query()->get();

        $cache->forget('settings');
        $settings = $cache->remember('settings', 60, function () use ($settings) {
            // Laravel >= 5.2, use 'lists' instead of 'pluck' for Laravel <= 5.1
            return $settings->pluck('value', 'key')->all();
        });
        $message = t('settings updated successfully');
        config()->set('settings', $settings);
        Artisan::call('config:cache');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        return $this->redirectWith(true, null, 'تم التحديث بنجاح');
    }
}
