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
        View::composer('layouts.default', function ($view) {
            $global_settings = \App\Models\GlobalSetting::first() ?? new \App\Models\GlobalSetting();
            $contact = \App\Models\ContactUs::first() ?? new \App\Models\ContactUs();
            $seoHeadings = \App\Models\SeoHeading::with('seoDatas')->get();
            $footerCategories = \App\Models\Category::where('status', 1)
                ->orderBy('sort_order')
                ->orderBy('category_name')
                ->take(4)
                ->get(['id', 'category_name']);
            $pageOff = \App\Models\PageOff::first();

            $view->with([
                'global_settings' => $global_settings,
                'contact' => $contact,
                'seoHeadings' => $seoHeadings,
                'footerCategories' => $footerCategories,
                'pageOff' => $pageOff,
            ]);
        });
    }
}
