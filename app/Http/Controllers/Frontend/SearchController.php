<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function index()
    {
        return view('frontend.pages.search');
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        // Static search index for now — will be replaced by DB-driven SearchService
        $searchIndex = [
            ['id' => 1, 'title' => 'Home', 'description' => 'TimeNest — The Work Operating System', 'type' => 'Page', 'url' => '/'],
            ['id' => 2, 'title' => 'For Organizations', 'description' => 'Complete workforce management for companies', 'type' => 'Product', 'url' => '/product/organizations'],
            ['id' => 3, 'title' => 'For Freelancers', 'description' => 'Manage clients, invoices, tasks, and revenue', 'type' => 'Product', 'url' => '/product/freelancers'],
            ['id' => 4, 'title' => 'Freelance Workspace', 'description' => 'Collaborative workspace for freelance teams', 'type' => 'Product', 'url' => '/product/freelance-workspace'],
            ['id' => 5, 'title' => 'Pricing', 'description' => 'Plans for freelancers and organizations', 'type' => 'Page', 'url' => '/pricing'],
            ['id' => 6, 'title' => 'AI Features', 'description' => 'Intelligence built into every workflow', 'type' => 'Feature', 'url' => '/ai'],
            ['id' => 7, 'title' => 'Attendance Management', 'description' => 'Track employee attendance with GPS and biometric support', 'type' => 'Feature', 'url' => '/features'],
            ['id' => 8, 'title' => 'Leave Management', 'description' => 'Automated leave tracking, approvals, and policies', 'type' => 'Feature', 'url' => '/features'],
            ['id' => 9, 'title' => 'Shift Management', 'description' => 'Create and manage rotating shifts with ease', 'type' => 'Feature', 'url' => '/features'],
            ['id' => 10, 'title' => 'Invoice Management', 'description' => 'Create, send, and track invoices for freelancers', 'type' => 'Feature', 'url' => '/product/freelancers'],
            ['id' => 11, 'title' => 'Roadmap', 'description' => 'See what we are building next', 'type' => 'Page', 'url' => '/roadmap'],
            ['id' => 12, 'title' => 'Security', 'description' => 'JWT auth, encryption, audit logs, GDPR ready', 'type' => 'Page', 'url' => '/security'],
            ['id' => 13, 'title' => 'What is TimeNest?', 'description' => 'TimeNest is a Work Operating System for organizations and freelancers', 'type' => 'FAQ', 'url' => '/faqs'],
            ['id' => 14, 'title' => 'Is TimeNest free?', 'description' => 'Core modules are free for freelancers', 'type' => 'FAQ', 'url' => '/faqs'],
            ['id' => 15, 'title' => 'About', 'description' => 'Our mission and story', 'type' => 'Page', 'url' => '/about'],
            ['id' => 16, 'title' => 'Contact', 'description' => 'Get in touch with the TimeNest team', 'type' => 'Page', 'url' => '/contact'],
        ];

        $results = collect($searchIndex)->filter(function ($item) use ($query) {
            $search = strtolower($query);
            return str_contains(strtolower($item['title']), $search) || str_contains(strtolower($item['description']), $search);
        })->values()->take(10);

        return response()->json(['results' => $results]);
    }
}
