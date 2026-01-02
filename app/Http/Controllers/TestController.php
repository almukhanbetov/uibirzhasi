<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\District;
use App\Models\Region;
use App\Models\Type;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        // $cities = [
        //     ['id'=>1, 'name'=>'Алматы','region_id'=>10],
        //     ['id'=>2, 'name'=>'Астана','region_id'=>20],
        // ];
        $cities = City::all();
      
        $regions = Region::all();
        $districts = District::all();
        $types = Type::all();

        return view('test', compact('types','cities','regions','districts'));
    }
}
