<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class CareersController extends Controller
{
    public function index() { return view('frontend.pages.careers'); }
}
