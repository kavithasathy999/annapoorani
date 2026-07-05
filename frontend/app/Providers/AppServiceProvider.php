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
            static $global_settings = null;
            static $contact = null;
            static $seoHeadings = null;
            static $footerCategories = null;

            if ($global_settings === null) {
                $global_settings = \App\Models\GlobalSetting::first() ?? new \App\Models\GlobalSetting();
            }

            if ($contact === null) {
                $contact = \App\Models\ContactUs::first() ?? new \App\Models\ContactUs();
            }

            if ($seoHeadings === null) {
                $seoHeadings = \App\Models\SeoHeading::with('seoDatas')->get();
            }

            if ($footerCategories === null) {
                $footerCategories = \App\Models\Category::orderBy('category_name')->take(4)->get();
            }

            $view->with([
                'global_settings' => $global_settings,
                'contact' => $contact,
                'seoHeadings' => $seoHeadings,
                'footerCategories' => $footerCategories
            ]);
        });
    }
}
