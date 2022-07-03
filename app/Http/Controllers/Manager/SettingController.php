<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:general settings management');
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
