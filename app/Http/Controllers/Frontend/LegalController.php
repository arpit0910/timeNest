<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class LegalController extends Controller
{
    public function privacy() { return view('frontend.pages.legal.privacy'); }
    public function terms() { return view('frontend.pages.legal.terms'); }
    public function compliance() { return view('frontend.pages.legal.compliance'); }
}
