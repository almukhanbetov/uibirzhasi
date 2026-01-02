<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Region;
use Illuminate\Http\Request;

class NewController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        $cities = City::all();
        $districts = District::all();
        return view('new', compact('regions', 'cities','districts'));
    }
}
