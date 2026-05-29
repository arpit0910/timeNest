<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        return view('frontend.pages.blog.index');
    }

    public function show(string $slug)
    {
        return view('frontend.pages.blog.show', compact('slug'));
    }
}
