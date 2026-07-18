<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannerImage;
use App\Models\Brand;
use App\Models\Product;
use App\Models\HomeSetting;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $pageData = Cache::remember('home.page_data', 300, function () {
                $settings = HomeSetting::first() ?? new HomeSetting();
                $featuredIds = collect($settings->featured_product_ids ?? [])->filter()->toArray();

                if (count($featuredIds) > 0) {
                    $products = Product::with('category')->whereIn('id', $featuredIds)->get();
                } else {
                    $products = Product::with('category')
                        ->where('product_regular_price', '>', 0)
                        ->latest()
                        ->take(7)
                        ->get();
                }

                $homeCategories = Category::where('status', 1)
                    ->orderBy('sort_order')
                    ->orderBy('category_name')
                    ->get(['id', 'category_name', 'category_image']);

                return compact('products', 'homeCategories');
            });

            // Homepage settings include time-sensitive festival data and must not be stale.
            $pageData['settings'] = HomeSetting::first() ?? new HomeSetting();

            // Keep banner status changes visible immediately instead of serving stale cached banners.
            $pageData['banners'] = BannerImage::where('is_active', 1)
                ->orderBy('banner_position', 'asc')
                ->get();

            // Brand activation changes must be visible immediately, independent of the homepage cache.
            $pageData['brands'] = Brand::where('is_active', 1)
                ->orderBy('sort_order', 'asc')
                ->get();

            return view('pages.home', $pageData);

        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('HomeController error: ' . $th->getMessage());
            // Return view with safe empty defaults
            $banners  = collect();
            $settings = new HomeSetting();
            $products = collect();
            $brands   = collect();
            $homeCategories = collect();
            return view('pages.home', compact('banners', 'products', 'settings', 'brands', 'homeCategories'));
        }
    }
}
