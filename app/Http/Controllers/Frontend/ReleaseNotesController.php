<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ReleaseNotesController extends Controller
{
    public function index() { return view('frontend.pages.release-notes'); }
}
