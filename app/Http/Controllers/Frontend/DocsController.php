<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class DocsController extends Controller
{
    public function index() { return view('frontend.pages.docs.index'); }
    public function show(string $slug) { return view('frontend.pages.docs.show', compact('slug')); }
}
