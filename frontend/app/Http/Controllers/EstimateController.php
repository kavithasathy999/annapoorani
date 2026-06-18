<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\State;
use Illuminate\Http\Request;

class EstimateController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)
            ->with(['products' => function ($query) {
                $query->whereNotNull('product_regular_price')
                    ->where('product_regular_price', '>', 0)
                    ->orderBy('product_name', 'asc');
            }])
            ->orderBy('category_name', 'asc')
            ->get();

        $states = State::orderByRaw("
            CASE 
                WHEN state LIKE 'Tamil%Nadu%' THEN 1
                WHEN state LIKE 'Kerala%' THEN 2
                WHEN state LIKE 'Karnataka%' THEN 3
                WHEN state LIKE 'Andhra%Pradesh%' THEN 4
                ELSE 5 
            END ASC
        ")->orderBy('state', 'asc')->get();
        $cities = City::orderBy('city_name')->get(['id', 'city_name', 'state_code']);
        $areas  = Area::orderBy('area_name')->get(['id', 'city_id', 'area_name', 'pincode']);

        return view('pages.estimate', compact('categories', 'states', 'cities', 'areas'));
    }


  
}
