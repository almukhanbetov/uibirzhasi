<?php

namespace App\Http\Controllers;

use App\Models\DifferentSection;


class DifferentController extends Controller
{
    public function show($id)
    {
        $section = DifferentSection::findOrFail($id);
       

        return view('different.show', compact('section'));
    }
}
