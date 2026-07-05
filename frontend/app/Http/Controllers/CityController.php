<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCities($stateId)
    {
        $cities = City::where('state_code', $stateId)   
                      ->orderBy('city_name')
                      ->get(['id', 'city_name']);

        return response()->json($cities);
    }

    public function getAreas($cityId)
    {
        $areas = Area::where('city_id', $cityId)
                     ->orderBy('area_name')
                     ->get(['id', 'area_name']);

        return response()->json($areas);
    }

    public function getCharges($cityId)
    {
        $charges = DB::table('additional_charges')
                     ->where('city_id', $cityId)
                     ->first();

        if ($charges) {
            return response()->json([
                'success' => true,
                'packing_price' => $charges->packing_price,
                'shipping_price' => $charges->shipping_price,
            ]);
        }

        return response()->json([
            'success' => false,
            'packing_price' => 0,
            'shipping_price' => 0,
        ]);
    }
}
