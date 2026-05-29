<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class FeaturesController extends Controller
{
    public function index()
    {
        return view('frontend.pages.features');
    }
}
