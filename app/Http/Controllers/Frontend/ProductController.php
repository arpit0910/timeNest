<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function organizations()
    {
        return view('frontend.pages.product.organizations');
    }

    public function freelancers()
    {
        return view('frontend.pages.product.freelancers');
    }

    public function workspace()
    {
        return view('frontend.pages.product.workspace');
    }
}
