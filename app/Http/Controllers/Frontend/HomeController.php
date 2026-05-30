<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            ['value' => '50000', 'suffix' => '+', 'label' => 'Attendance Records Processed'],
            ['value' => '1', 'suffix' => 'M+', 'label' => 'Work Hours Tracked'],
            ['value' => '100', 'prefix' => '₹', 'suffix' => 'M+', 'label' => 'Operational Costs Optimized'],
            ['value' => '99', 'suffix' => '.9%', 'label' => 'Compliance Accuracy'],
        ];

        $faqs = config('faqs', []);
        $testimonials = [
            ['name' => 'Arjun Mehta', 'role' => 'CEO', 'company' => 'TechVista Solutions', 'content' => 'TimeNest transformed how we manage our 200+ employees. The attendance and shift management alone saved us 40 hours per month.', 'rating' => 5],
            ['name' => 'Priya Sharma', 'role' => 'Freelance Designer', 'company' => 'Independent', 'content' => 'Finally a tool that understands freelancers. I manage all my clients, invoices, and projects in one place. And the free tier is genuinely useful.', 'rating' => 5],
            ['name' => 'Rahul Kapoor', 'role' => 'HR Head', 'company' => 'CloudSync India', 'content' => 'The AI fraud detection caught attendance anomalies we never would have found manually. Worth every penny.', 'rating' => 5],
        ];

        return view('frontend.pages.home', compact('stats', 'faqs', 'testimonials'));
    }
}
