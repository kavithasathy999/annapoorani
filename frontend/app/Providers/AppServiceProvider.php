<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SeoHeading;
use App\Models\GlobalSetting;
use App\Models\ContactUs;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }



    public function boot(): void
    {
        View::composer('*', function ($view) {

            $global_settings = GlobalSetting::first();
            if (!$global_settings) {
                $global_settings = new GlobalSetting();
            }

            $contact = ContactUs::first();
            if (!$contact) {
                $contact = new ContactUs();
            }

            $seoHeadings = SeoHeading::with('seoDatas')->get();

            $view->with([
                'global_settings' => $global_settings,
                'contact' => $contact,
                'seoHeadings' => $seoHeadings
            ]);
        });
    }
}
