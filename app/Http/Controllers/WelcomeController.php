<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\DifferentSection;
use App\Models\District;
use App\Models\Listing;
use App\Models\different;
use App\Models\Region;
use App\Models\Type;

class WelcomeController extends Controller
{
    public function index()
    {
        // $cities = [
        //     ['id'=>1, 'name'=>'Алматы','region_id'=>10],
        //     ['id'=>2, 'name'=>'Астана','region_id'=>20],
        // ];
        $cities = City::all();
        $regions = Region::all();
        $districts = District::all();
        $types = Type::all();
        $listings = Listing::all();
        $differents = DifferentSection::where('is_active',1)->orderBy('sort_order')->get();
        return view('welcome', compact('types', 'cities', 'regions', 'districts', 'listings','differents'));
    }
    public function sale(){
        dd("sale");
    }
    public function buy(){
        dd("buy");
    }
}
