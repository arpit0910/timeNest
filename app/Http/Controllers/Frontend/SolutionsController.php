<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class SolutionsController extends Controller
{
    public function show(string $slug)
    {
        $validSlugs = ['workforce-management', 'operations-management', 'financial-operations', 'freelancer-management', 'ai-operations'];
        if (!in_array($slug, $validSlugs)) abort(404);
        return view('frontend.pages.solutions.show', compact('slug'));
    }
}
