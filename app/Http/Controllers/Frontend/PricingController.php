<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PricingController extends Controller
{
    public function index()
    {
        return view('frontend.pages.pricing');
    }
}
