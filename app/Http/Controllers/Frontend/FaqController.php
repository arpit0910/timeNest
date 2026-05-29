<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        return view('frontend.pages.faqs');
    }
}
