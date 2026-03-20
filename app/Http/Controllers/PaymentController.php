<?php

namespace App\Http\Controllers;

use App\Models\PaymentSection;

class PaymentController extends Controller
{

    public function show($id)
    {        
        $section = PaymentSection::findOrFail($id);          
        return view('payment.show',compact('section'));

    }

}