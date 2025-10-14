<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
    Schema::defaultStringLength(191);

    if (! $this->app->runningInConsole()) {
        // Check if table exists before querying
        if (Schema::hasTable('settings')) {
            $settings = Setting::all('key', 'value')
                ->keyBy('key')
                ->transform(function ($setting) {
                    return $setting->value;
                })
                ->toArray();

            config(['settings' => $settings]);

            if (isset($settings['app_name'])) {
                config(['app.name' => $settings['app_name']]);
            }
        }
    }

    Paginator::useBootstrap();
}

}
