<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            ['value' => '500', 'suffix' => '+', 'label' => 'Organizations'],
            ['value' => '10,000', 'suffix' => '+', 'label' => 'Freelancers'],
            ['value' => '25', 'suffix' => '+', 'label' => 'Modules'],
            ['value' => '12', 'suffix' => '+', 'label' => 'Countries'],
        ];

        $faqs = [
            ['question' => 'What is TimeNest?', 'answer' => 'TimeNest is a Work Operating System that combines workforce management for organizations with a complete freelancer management platform. It serves three distinct user types: Organizations, Individual Freelancers, and Freelance Workspaces.'],
            ['question' => 'Is TimeNest free for freelancers?', 'answer' => 'Yes! Core modules are completely free for individual freelancers. You can manage clients, invoices, tasks, and projects without paying anything. Advanced AI features and Freelance Workspace require a Pro subscription.'],
            ['question' => 'How is a Freelance Workspace different from an Organization?', 'answer' => 'Organizations manage employees with HR features like attendance, leaves, and shifts. Freelance Workspaces manage collaborators — freelancers working together on shared projects, tasks, and invoices. Think agencies, creative studios, and consulting groups.'],
            ['question' => 'Do I need a credit card to get started?', 'answer' => 'No. Freelancers can sign up and start using core modules immediately without any payment information. Organizations can book a demo to explore the full platform.'],
            ['question' => 'What AI features does TimeNest offer?', 'answer' => 'TimeNest AI includes a Workforce Analyst for attendance anomaly detection, Fraud Detection for suspicious activities, an Executive Dashboard with natural language queries, and a Freelancer Assistant for invoice and revenue insights.'],
            ['question' => 'Can TimeNest replace multiple tools?', 'answer' => 'Absolutely. TimeNest is designed to replace fragmented tool stacks. Instead of separate tools for HR, attendance, invoicing, project management, and analytics, TimeNest provides everything in one platform.'],
            ['question' => 'Is my data secure?', 'answer' => 'Yes. TimeNest uses JWT authentication, data encryption at rest and in transit, comprehensive audit logs, and role-based access controls. We are working towards GDPR compliance.'],
            ['question' => 'What integrations are available?', 'answer' => 'We are building integrations with Google Workspace, Microsoft Teams, Slack, Zoom, Razorpay, Stripe, and more. All integrations are currently in development and will be available soon.'],
        ];

        $testimonials = [
            ['name' => 'Arjun Mehta', 'role' => 'CEO', 'company' => 'TechVista Solutions', 'content' => 'TimeNest transformed how we manage our 200+ employees. The attendance and shift management alone saved us 40 hours per month.', 'rating' => 5],
            ['name' => 'Priya Sharma', 'role' => 'Freelance Designer', 'company' => 'Independent', 'content' => 'Finally a tool that understands freelancers. I manage all my clients, invoices, and projects in one place. And the free tier is genuinely useful.', 'rating' => 5],
            ['name' => 'Rahul Kapoor', 'role' => 'HR Head', 'company' => 'CloudSync India', 'content' => 'The AI fraud detection caught attendance anomalies we never would have found manually. Worth every penny.', 'rating' => 5],
        ];

        return view('frontend.pages.home', compact('stats', 'faqs', 'testimonials'));
    }
}
