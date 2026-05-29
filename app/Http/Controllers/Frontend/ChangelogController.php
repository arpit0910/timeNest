<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ChangelogController extends Controller
{
    public function index() { return view('frontend.pages.changelog'); }
}
