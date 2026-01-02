<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\City;
use App\Models\District;

class LocationController extends Controller
{
    public function regions()
    {
        return Region::orderBy('name')->get();
    }

    public function cities($regionId)
    {
        return City::where('region_id', $regionId)
            ->orderBy('name')
            ->get();
    }

    public function districts($cityId)
    {
        return District::where('city_id', $cityId)
            ->orderBy('name')
            ->get();
    }
}
