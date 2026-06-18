<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
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
}
