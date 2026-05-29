<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class CompareController extends Controller
{
    public function show(string $slug)
    {
        return view('frontend.pages.compare.show', compact('slug'));
    }
}
