<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannerImage;
use App\Models\Brand;
use App\Models\Product;
use App\Models\HomeSetting;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $banners  = BannerImage::orderBy('banner_position', 'asc')->get();
            $settings = HomeSetting::first() ?? new HomeSetting();

            $featured_ids = collect($settings->featured_product_ids ?? [])->filter()->toArray();
            $brands = Brand::where('is_active', 1)->orderBy('sort_order', 'asc')->get();

            if (count($featured_ids) > 0) {
                $products = Product::with('category')->whereIn('id', $featured_ids)->get();
            } else {
                // Fallback: latest 7 products with valid price
                $products = Product::with('category')
                    ->where('product_regular_price', '>', 0)
                    ->latest()
                    ->take(7)
                    ->get();
            }

            return view('pages.home', compact('banners', 'products', 'settings', 'brands'));

        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('HomeController error: ' . $th->getMessage());
            // Return view with safe empty defaults
            $banners  = collect();
            $settings = new HomeSetting();
            $products = collect();
            $brands   = collect();
            return view('pages.home', compact('banners', 'products', 'settings', 'brands'));
        }
    }
}
