<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InstantPayment extends Controller
{
    //
    public function get_intstant_payment()
    {
        return view('pages.payments.instant_payment');
    }
}