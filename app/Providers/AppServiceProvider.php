<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\ListingMangga::observe(\App\Observers\ListingObserver::class);

        // Dynamically load system settings if table exists
        if (\Illuminate\Support\Facades\Schema::hasTable('system_settings')) {
            $appName = \App\Models\SystemSetting::get('app_name');
            if ($appName) {
                config(['app.name' => $appName]);
            }
            
            $timezone = \App\Models\SystemSetting::get('timezone');
            if ($timezone) {
                config(['app.timezone' => $timezone]);
                date_default_timezone_set($timezone);
            }
            
            $locale = \App\Models\SystemSetting::get('locale');
            if ($locale) {
                config(['app.locale' => $locale]);
                app()->setLocale($locale);
            }
        }
    }
}
