<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class IndustriesController extends Controller
{
    public function show(string $slug)
    {
        $validSlugs = ['startups', 'it-companies', 'agencies', 'consulting-firms', 'manufacturing', 'healthcare', 'retail', 'education'];
        if (!in_array($slug, $validSlugs)) abort(404);
        return view('frontend.pages.industries.show', compact('slug'));
    }
}
