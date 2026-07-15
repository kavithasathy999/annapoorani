<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\State;
use App\Models\PriceList;
use App\Models\HomeSetting;
use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EstimateController extends Controller
{
    public function index()
    {
        $categories = Cache::remember('estimate.categories', 300, function () {
            return Category::where('status', 1)
                ->with(['products' => function ($query) {
                    $query->whereNotNull('product_regular_price')
                        ->where('product_regular_price', '>', 0)
                        ->orderBy('sort_order', 'asc')
                        ->orderBy('product_name', 'asc');
                }])
                ->orderBy('sort_order', 'asc')
                ->orderBy('category_name', 'asc')
                ->get();
        });

        $states = Cache::remember('estimate.states', 86400, function () {
            return State::orderByRaw("
                CASE 
                    WHEN state LIKE 'Tamil%Nadu%' THEN 1
                    WHEN state LIKE 'Kerala%' THEN 2
                    WHEN state LIKE 'Karnataka%' THEN 3
                    WHEN state LIKE 'Andhra%Pradesh%' THEN 4
                    ELSE 5 
                END ASC
            ")->orderBy('state', 'asc')->get();
        });

        $cities = Cache::remember('estimate.cities', 86400, function () {
            return City::orderBy('city_name')->get(['id', 'city_name', 'state_code']);
        });

        $areas = Cache::remember('estimate.areas', 86400, function () {
            return Area::orderBy('area_name')->get(['id', 'city_id', 'area_name', 'pincode']);
        });
        
        $globalCharges = DB::table('settings')
            ->whereIn('setting_key', [
                'additional_charge_name',
                'additional_charge_percentage',
            ])
            ->pluck('setting_value', 'setting_key');

        $priceList = Cache::remember('estimate.price_list', 300, fn () => PriceList::first());
        $settings = Cache::remember('home.settings', 300, fn () => HomeSetting::first() ?? new HomeSetting());
        $globalSettings = Cache::remember('layout.global_settings', 300, fn () => GlobalSetting::first() ?? new GlobalSetting());
        $minOrder = $settings->min_order_value ?? 0;
        $globalGst = $settings->global_gst ?? 0;
        $showDiscount = $globalSettings->show_discount ?? true;

        return view('pages.estimate', compact(
            'categories',
            'states',
            'cities',
            'areas',
            'globalCharges',
            'priceList',
            'settings',
            'minOrder',
            'globalGst',
            'showDiscount'
        ));
    }

    public function downloadPDF()
    {
        $cachePath = storage_path('app/public/price-list-cached.pdf');

        // Check the latest update timestamp from Categories, Products, and Settings
        $lastCategoryUpdate      = Category::max('updated_at');
        $lastProductUpdate       = Product::max('updated_at');
        $lastHomeSettingUpdate   = \App\Models\HomeSetting::max('updated_at');
        $lastGlobalSettingUpdate = \App\Models\GlobalSetting::max('updated_at');

        $latestDbUpdate = max(
            $lastCategoryUpdate ? strtotime($lastCategoryUpdate) : 0,
            $lastProductUpdate ? strtotime($lastProductUpdate) : 0,
            $lastHomeSettingUpdate ? strtotime($lastHomeSettingUpdate) : 0,
            $lastGlobalSettingUpdate ? strtotime($lastGlobalSettingUpdate) : 0
        );

        $shouldRegenerate = true;
        if (file_exists($cachePath)) {
            $cachedFileTime = filemtime($cachePath);
            if ($cachedFileTime >= $latestDbUpdate) {
                $shouldRegenerate = false;
            }
        }

        if ($shouldRegenerate) {
            $categories = Category::where('status', 1)
                ->with(['products' => function ($query) {
                    $query->whereNotNull('product_regular_price')
                        ->where('product_regular_price', '>', 0)
                        ->orderBy('sort_order', 'asc')
                        ->orderBy('product_name', 'asc');
                }])
                ->orderBy('sort_order', 'asc')
                ->orderBy('category_name', 'asc')
                ->get();

            $settings = \App\Models\HomeSetting::first();

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.price-list', compact('categories', 'settings'));
            
            // Save to storage
            $pdfContent = $pdf->output();
            if (!file_exists(dirname($cachePath))) {
                mkdir(dirname($cachePath), 0755, true);
            }
            file_put_contents($cachePath, $pdfContent);
        }

        return response()->download($cachePath, 'Sri-Annapoorani-Crackers-Price-List-' . date('Y-m-d') . '.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
