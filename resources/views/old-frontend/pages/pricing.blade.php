<x-frontend-layout.app>
<x-slot name="metaTitle">Pricing — TimeNest</x-slot>

<style>
/* --------- BASE STYLES --------- */
.tn-page { background: #fafafa; color: #334155; }

/* --------- TYPOGRAPHY --------- */
.tn-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: #6366f1; }
.tn-hero-title { font-size: clamp(3rem, 5vw, 4.5rem); font-weight: 800; letter-spacing: -0.04em; color: #0f172a; line-height: 1.1; margin-bottom: 1.5rem; }
.tn-hero-subtitle { font-size: 1.25rem; color: #64748b; max-width: 600px; margin: 0 auto 3rem; line-height: 1.6; }

/* --------- PRICING CARDS --------- */
.tn-pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; max-width: 1200px; margin: 0 auto; align-items: stretch; }

.tn-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 24px; padding: 2.5rem; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; flex-direction: column; }
.tn-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -10px rgba(99,102,241,0.1); border-color: rgba(99,102,241,0.3); }

.tn-card-pro { background: #08080f; border: 1px solid rgba(99,102,241,0.4); border-radius: 24px; padding: 3rem 2.5rem; position: relative; box-shadow: 0 30px 60px -15px rgba(99,102,241,0.25); color: #ffffff; transform: scale(1.03); display: flex; flex-direction: column; z-index: 10; overflow: hidden; }

.tn-price-wrapper { margin-bottom: 2rem; }
.tn-price { font-size: 3.5rem; font-weight: 800; color: inherit; line-height: 1; margin-bottom: 0.5rem; letter-spacing: -0.04em; }
.tn-price span { font-size: 1rem; font-weight: 500; color: #94a3b8; letter-spacing: normal; }

/* --------- BUTTONS --------- */
.tn-btn-outline { display: inline-flex; align-items: center; justify-content: center; width: 100%; padding: 0.875rem 1.5rem; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; transition: all 0.2s; border: 1px solid #cbd5e1; color: #334155; background: transparent; }
.tn-btn-outline:hover { background: #f1f5f9; border-color: #94a3b8; color: #0f172a; }

.tn-btn-primary { display: inline-flex; align-items: center; justify-content: center; width: 100%; padding: 0.875rem 1.5rem; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; transition: all 0.2s; background: #6366f1; color: #ffffff; border: none; box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
.tn-btn-primary:hover { background: #4f46e5; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(99,102,241,0.4); }

/* --------- FEATURE LISTS --------- */
.tn-features-header { font-weight: 700; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1.5rem; }
.tn-card .tn-features-header { color: #0f172a; }
.tn-card-pro .tn-features-header { color: #ffffff; }

.tn-feature-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem; text-align: left; flex-grow: 1; }
.tn-feature-list li { display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.95rem; line-height: 1.5; font-weight: 500; }
.tn-card .tn-feature-list li { color: #475569; }
.tn-card-pro .tn-feature-list li { color: #e2e8f0; }

.tn-icon-check { width: 20px; height: 20px; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; margin-top: 2px; }
.tn-card .tn-icon-check { color: #6366f1; }
.tn-card-pro .tn-icon-check { color: #818cf8; }

/* --------- COMPARISON TABLE --------- */
.tn-table-wrapper { max-width: 1100px; margin: 5rem auto 2rem; background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); }
.tn-table { width: 100%; border-collapse: collapse; text-align: left; }
.tn-table th { padding: 1.5rem; background: #f8fafc; font-weight: 700; color: #0f172a; font-size: 1rem; border-bottom: 2px solid #e2e8f0; }
.tn-table td { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; color: #475569; font-size: 0.95rem; }
.tn-table tr:last-child td { border-bottom: none; }
.tn-table td.text-center, .tn-table th.text-center { text-align: center; }

/* --------- FAQ --------- */
.tn-faq-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; max-width: 1000px; margin: 0 auto; text-align: left; }
.tn-faq-q { font-size: 1.125rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
.tn-faq-a { font-size: 1rem; color: #475569; line-height: 1.6; }

@media (max-width: 1024px) {
  .tn-pricing-grid { grid-template-columns: 1fr; }
  .tn-card-pro { transform: scale(1); padding: 2.5rem; }
  .tn-faq-grid { grid-template-columns: 1fr; }
}
</style>

<div class="tn-page">
  
  {{-- HERO SECTION --}}
  <section style="padding: 10rem 2rem 5rem; text-align: center; position: relative; overflow: hidden;">
    <div style="position:absolute; top:-20%; left:50%; transform:translateX(-50%); width:600px; height:600px; background:radial-gradient(circle, rgba(99,102,241,0.1) 0%, transparent 70%); filter:blur(60px); z-index:0; pointer-events:none;"></div>
    
    <div style="position: relative; z-index: 10;">
      <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(99,102,241,0.1); padding:0.5rem 1rem; border-radius:999px; margin-bottom:1.5rem;">
        <span class="tn-eyebrow">Transparent Pricing</span>
      </div>
      <h1 class="tn-hero-title">Simple pricing for<br>modern teams.</h1>
      <p class="tn-hero-subtitle">Start free as a freelancer. Scale to Pro or Organization when you're ready. No credit card required to begin.</p>
    </div>
  </section>

  {{-- PRICING GRID --}}
{{-- Section 4: Product Lines Cards --}}
      <section class="py-12 sm:py-16 lg:py-20 bg-white">
          <div class="max-w-7xl mx-auto px-6 lg:px-8">
              <div class="text-center max-w-3xl mx-auto mb-14 lg:mb-16">
                  <x-frontend-base.badge variant="primary" class="mb-4">Platform Products</x-frontend-base.badge>
                  <h2 class="font-display text-3xl lg:text-4xl font-bold text-content-strong mb-4">Three products, one 
platform</h2>
                  <p class="text-content-muted text-lg">TimeNest isn't one tool â€” it's three powerful operating 
systems unified under a single platform. Choose the product that fits your workflow, and scale seamlessly without ever 
migrating data.</p>
              </div>
              
              @php
                  $products = [
                      [
                          'title' => 'For Organizations',
                          'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 
4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                          'desc' => 'Complete workforce and operations management for companies of any size. Unify HR, 
attendance, shifts, approvals, and departmental workflows into a single real-time operating system.',
                          'audience' => ['Startups', 'SMBs', 'Enterprises', 'Distributed Teams'],
                          'stats' => [['label' => 'Employees', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 
0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z'], ['label' => 'Attendance', 'icon' => 'M12 8v4l3 
3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'], ['label' => 'Approvals', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 
0z']],
                          'features' => ['Employee Directory & Profiles', 'Attendance Tracking & GPS', 'Leave 
Management', 'Shift Scheduling & Rostering', 'Departments & Teams', 'Roles & Permissions', 'Multi-Level Approvals', 
'Workforce Analytics', 'Audit Logs', 'Compliance Monitoring'],
                          'bestFor' => 'Managing Employees',
                          'basis' => 'Employee-Based',
                          'cta' => 'Book Organization Demo',
                          'url' => route('frontend.book-demo'),
                          'color' => 'brand',
                          'widgetType' => 'org',
                      ],
                      [
                          'title' => 'For Freelancers',
                          'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                          'desc' => 'Everything a solo freelancer needs to manage clients, revenue, and projects from 
one dashboard. Run your entire freelance business â€” CRM, invoicing, tasks, and AI forecasting â€” forever free.',
                          'audience' => ['Solo Freelancers', 'Consultants', 'Creators', 'Independent Professionals'],
                          'stats' => [['label' => 'Clients', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 
0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 
019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'], ['label' => 'Invoices', 'icon' => 'M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 
21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'], ['label' => 'Projects', 'icon' => 'M4 6a2 2 0 
012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 
01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z']],
                          'features' => ['Client CRM & Lead Tracking', 'Professional Invoicing', 'Quotations & 
Proposals', 'Revenue Analytics', 'Project Management', 'Task Tracking & Kanban', 'Document Management', 'Payment 
Tracking', 'AI Revenue Forecasting', 'Time Logging'],
                          'bestFor' => 'Running Your Solo Business',
                          'basis' => 'Individual-Based',
                          'cta' => 'Start Freelancing Free',
                          'url' => '/register',
                          'color' => 'indigo',
                          'widgetType' => 'freelancer',
                      ],
                      [
                          'title' => 'Freelance Workspace',
                          'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 
20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 
0z',
                          'desc' => 'A collaborative workspace for freelance teams, agencies, and studios. Share 
projects, consolidate invoicing, and track team utilization â€” without corporate overhead.',
                          'audience' => ['Agencies', 'Studios', 'Consulting Teams', 'Collaborative Freelance Groups'],
                          'stats' => [['label' => 'Collaborators', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 
0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z'], ['label' => 'Projects', 'icon' => 'M19 11H5m14 
0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 
012-2h6a2 2 0 012 2v2M7 7h10'], ['label' => 'Reporting', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 
2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 
2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z']],
                          'features' => ['Collaborator Management', 'Shared Projects & Files', 'Shared Client 
Billing', 'Workspace Analytics', 'Team Utilization Tracking', 'Revenue Visibility', 'Collaborative Reporting', 'Shared 
Task Management', 'Agency Workflows', 'Shared Documents'],
                          'bestFor' => 'Managing Collaborative Freelance Teams',
                          'basis' => 'Collaborator-Based',
                          'cta' => 'Launch Your Workspace',
                          'url' => route('frontend.pricing'),
                          'color' => 'amber',
                          'pro' => true,
                          'widgetType' => 'workspace',
                      ],
                  ];
              @endphp
  
              <div class="grid md:grid-cols-3 gap-6 lg:gap-8">
                  @foreach($products as $product)
                      <div class="group rounded-2xl border border-surface-border bg-white p-6 sm:p-8 lg:p-9 
hover:border-{{ $product['color'] }}-300 hover:shadow-2xl hover:shadow-{{ $product['color'] }}-500/10 
hover:-translate-y-1 transition-all duration-400 flex flex-col relative overflow-hidden">
                          
                          {{-- Background glow on hover --}}
                          <div class="absolute inset-0 bg-gradient-to-br from-{{ $product['color'] }}-50/0 
via-transparent to-{{ $product['color'] }}-50/0 group-hover:from-{{ $product['color'] }}-50/40 group-hover:to-{{ 
$product['color'] }}-50/20 transition-all duration-500 pointer-events-none"></div>
                          
                          {{-- Ghost icon --}}
                          <div class="absolute top-0 right-0 p-8 opacity-[0.03] group-hover:opacity-[0.08] 
transition-opacity duration-500">
                              <svg class="w-32 h-32 text-{{ $product['color'] }}-600 -mr-10 -mt-10" fill="none" 
stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="{{ 
$product['icon'] }}"/></svg>
                          </div>
                          
                          {{-- Icon container with hover animation --}}
                          <div class="w-14 h-14 rounded-xl bg-{{ $product['color'] }}-50 flex items-center 
justify-center mb-5 text-{{ $product['color'] }}-600 border border-{{ $product['color'] }}-100 relative z-10 
group-hover:bg-{{ $product['color'] }}-500 group-hover:text-white group-hover:border-{{ $product['color'] }}-500 
group-hover:shadow-lg group-hover:shadow-{{ $product['color'] }}-500/25 transition-all duration-300">
                              <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none" 
stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ 
$product['icon'] }}"/></svg>
                          </div>
                          
                          {{-- Title --}}
                          <h3 class="font-display text-2xl font-bold text-content-strong mb-2 relative z-10">{{ 
$product['title'] }}</h3>
                          
                          {{-- Audience tag --}}
                          <div class="flex items-center gap-1.5 mb-4 relative z-10">
                              <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-widest">Ideal 
For:</span>
                              <span class="text-[10px] font-medium text-neutral-500">{{ implode(' â€¢ ', 
$product['audience']) }}</span>
                          </div>
                          
                          @if(isset($product['pro']))
  
                          @endif
                          
                          {{-- Description --}}
                          <p class="text-content-muted text-sm leading-relaxed mb-5 relative z-10">{{ $product['desc'] 
}}</p>
                          
                          {{-- Stats micro-badges row --}}
                          <div class="flex items-center gap-2 mb-6 relative z-10">
                              @foreach($product['stats'] as $stat)
                                  <div class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-neutral-50 border 
border-neutral-100 group-hover:bg-{{ $product['color'] }}-50/50 group-hover:border-{{ $product['color'] }}-100/50 
transition-colors duration-300">
                                      <svg class="w-3.5 h-3.5 text-{{ $product['color'] }}-500" fill="none" 
stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ 
$stat['icon'] }}"/></svg>
                                      <span class="text-[10px] font-semibold text-neutral-600">{{ $stat['label'] 
}}</span>
                                  </div>
                              @endforeach
                          </div>
  
                          {{-- Mini Dashboard Preview Widget --}}
                          <div class="relative z-10 mb-6 rounded-xl border border-neutral-200/60 bg-gradient-to-br 
from-neutral-50 to-white p-3 overflow-hidden">
                              @if($product['widgetType'] === 'org')
                                  {{-- Organization: Attendance mini-widget --}}
                                  <div x-data="{ present: 47, total: 52, rate: 90.4 }" x-init="setInterval(() => { 
present = present === 47 ? 50 : present === 50 ? 52 : 47; rate = Math.round(present/total*1000)/10; }, 3000)">
                                      <div class="flex items-center justify-between mb-2">
                                          <span class="text-[9px] font-bold text-neutral-400 uppercase 
tracking-wider">Today's Attendance</span>
                                          <span class="text-[8px] font-bold text-emerald-600 bg-emerald-50 px-1.5 
py-0.5 rounded border border-emerald-200 flex items-center gap-0.5 animate-pulse">
                                              <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Live
                                          </span>
                                      </div>
                                      <div class="flex items-end justify-between">
                                          <div>
                                              <span class="text-lg font-bold text-neutral-800 transition-all 
duration-500" x-text="present + '/' + total"></span>
                                              <span class="text-[9px] text-neutral-400 ml-1">employees</span>
                                          </div>
                                          <span class="text-xs font-bold transition-all duration-500" :class="rate > 
95 ? 'text-emerald-600' : 'text-amber-600'" x-text="rate + '%'"></span>
                                      </div>
                                      <div class="w-full h-1.5 bg-neutral-100 rounded-full mt-2 overflow-hidden">
                                          <div class="h-full rounded-full transition-all duration-700 ease-out" 
:class="rate > 95 ? 'bg-emerald-500' : 'bg-amber-500'" :style="'width: ' + rate + '%'"></div>
                                      </div>
                                  </div>
                              @elseif($product['widgetType'] === 'freelancer')
                                  {{-- Freelancer: Revenue mini-widget --}}
                                  <div x-data="{ revenue: 284500, invoices: 12, paid: 9 }" x-init="setInterval(() => { 
revenue += Math.floor(Math.random() * 15000); paid = Math.min(paid + 1, invoices); }, 4000)">
                                      <div class="flex items-center justify-between mb-2">
                                          <span class="text-[9px] font-bold text-neutral-400 uppercase 
tracking-wider">Revenue This Month</span>
                                          <span class="text-[8px] font-bold text-indigo-600 bg-indigo-50 px-1.5 py-0.5 
rounded border border-indigo-200">Tracking</span>
                                      </div>
                                      <div class="flex items-end justify-between">
                                          <div>
                                              <span class="text-lg font-bold text-neutral-800 transition-all 
duration-500" x-text="'â‚¹' + revenue.toLocaleString()"></span>
                                          </div>
                                          <div class="text-right">
                                              <span class="text-[9px] text-neutral-400 block" x-text="paid + '/' + 
invoices + ' paid'"></span>
                                          </div>
                                      </div>
                                      <div class="flex gap-1 mt-2">
                                          <template x-for="i in invoices">
                                              <div class="flex-1 h-1.5 rounded-full transition-all duration-500" 
:class="i <= paid ? 'bg-indigo-500' : 'bg-neutral-100'"></div>
                                          </template>
                                      </div>
                                  </div>
                              @elseif($product['widgetType'] === 'workspace')
                                  {{-- Workspace: Team utilization mini-widget --}}
                                  <div x-data="{ members: [{n:'Sarah K.', u:92}, {n:'James L.', u:78}, {n:'Maria R.', 
u:85}] }">
                                      <div class="flex items-center justify-between mb-2">
                                          <span class="text-[9px] font-bold text-neutral-400 uppercase 
tracking-wider">Team Utilization</span>
                                          <span class="text-[8px] font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 
rounded border border-amber-200">3 Active</span>
                                      </div>
                                      <div class="space-y-1.5">
                                          <template x-for="m in members" :key="m.n">
                                              <div class="flex items-center gap-2">
                                                  <span class="text-[9px] font-medium text-neutral-600 w-14 truncate" 
x-text="m.n"></span>
                                                  <div class="flex-1 h-1.5 bg-neutral-100 rounded-full overflow-hidden">
                                                      <div class="h-full bg-amber-500 rounded-full transition-all 
duration-700" :style="'width: ' + m.u + '%'"></div>
                                                  </div>
                                                  <span class="text-[9px] font-bold text-neutral-500 w-7 text-right" 
x-text="m.u + '%'"></span>
                                              </div>
                                          </template>
                                      </div>
                                  </div>
                              @endif
                          </div>
                          
                          {{-- Differentiation block --}}
                          <div class="relative z-10 mb-6 flex items-center gap-3 px-3.5 py-2.5 rounded-lg bg-{{ 
$product['color'] }}-50/60 border border-{{ $product['color'] }}-100/60">
                              <svg class="w-4 h-4 text-{{ $product['color'] }}-500 shrink-0" fill="none" 
stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 
10V3L4 14h7v7l9-11h-7z"/></svg>
                              <div>
                                  <span class="text-[9px] font-bold text-{{ $product['color'] }}-500 uppercase 
tracking-widest">Best For</span>
                                  <p class="text-xs font-bold text-{{ $product['color'] }}-800 leading-tight">{{ 
$product['bestFor'] }}</p>
                              </div>
                          </div>
                          
                          {{-- Feature list --}}
                          <div class="mb-8 flex-1 relative z-10">
                              <h4 class="text-[10px] font-semibold text-content-strong uppercase tracking-widest 
mb-3">Platform Features</h4>
                              <ul class="grid grid-cols-1 gap-2">
                                  @foreach($product['features'] as $f)
                                      <li class="flex items-center gap-2 text-[13px] text-content-muted">
                                          <svg class="w-4 h-4 text-{{ $product['color'] }}-500 shrink-0" fill="none" 
stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" 
d="M5 13l4 4L19 7"/></svg>
                                          {{ $f }}
                                      </li>
                                  @endforeach
                              </ul>
                          </div>
                          
                          {{-- CTA Button --}}
                          <x-frontend-base.button :href="$product['url']" variant="outline" class="w-full relative 
z-10 bg-white border-surface-border hover:bg-{{ $product['color'] }}-50 hover:text-{{ $product['color'] }}-700 
hover:border-{{ $product['color'] }}-200 transition-all duration-300">{{ $product['cta'] }}</x-frontend-base.button>
                          
                          {{-- Product comparison indicator --}}
                          <div class="relative z-10 mt-4 pt-4 border-t border-neutral-100 flex items-center 
justify-center gap-2">
                              <svg class="w-3.5 h-3.5 text-{{ $product['color'] }}-400" fill="none" 
stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ 
$product['icon'] }}"/></svg>
                              <span class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest">{{ 
$product['basis'] }}</span>
                          </div>
                      </div>
                  @endforeach
              </div>
          </div>
      </section>
  {{-- DETAILED COMPARISON TABLE --}}
  <section style="padding: 2rem 2rem 6rem; position: relative; background: #ffffff; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <h3 style="font-size:1.8rem;font-weight:800;color:#0f172a;text-align:center;margin-bottom:2rem;">Feature Comparison</h3>
    <div class="tn-table-wrapper">
      <table class="tn-table">
        <thead>
          <tr>
            <th>Feature</th>
            <th>For Freelancers</th>
            <th style="color:#6366f1;">Freelance Workspace</th>
            <th>For Organizations</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Client Management</td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto; color:#6366f1;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
          </tr>
          <tr>
            <td>Invoices & Payments</td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto; color:#6366f1;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
          </tr>
          <tr>
            <td>Tasks & Projects</td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto; color:#6366f1;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
          </tr>
          <tr>
            <td>AI Features</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto; color:#6366f1;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
          </tr>
          <tr>
            <td>Freelance Workspace</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto; color:#6366f1;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
          </tr>
          <tr>
            <td>Employee Management</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
          </tr>
          <tr>
            <td>Attendance & Leaves</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
          </tr>
          <tr>
            <td>Shift Management</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
          </tr>
          <tr>
            <td>Custom Workflows</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
          </tr>
          <tr>
            <td>Dedicated Support</td>
            <td class="text-center" style="color:#cbd5e1;">—</td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto; color:#6366f1;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
            <td class="text-center"><svg class="tn-icon-check" style="width:20px; margin:0 auto;" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg></td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  {{-- FAQ SECTION --}}
  <section style="padding: 6rem 2rem; background: #fafafa;">
    <div style="text-align:center; margin-bottom:4rem;">
      <h2 style="font-size:clamp(2rem, 3vw, 2.5rem); font-weight:800; color:#0f172a;">Frequently asked questions</h2>
    </div>
    <div class="tn-faq-grid">
      <div>
        <h4 class="tn-faq-q">Do I need a credit card to sign up?</h4>
        <p class="tn-faq-a">No, you can sign up for the Free plan without entering any payment details. You only need a card if you decide to upgrade to Pro.</p>
      </div>
      <div>
        <h4 class="tn-faq-q">Can I switch plans later?</h4>
        <p class="tn-faq-a">Absolutely. You can upgrade from Free to Pro at any time to unlock AI and workspace features. You can also cancel your Pro subscription whenever you want.</p>
      </div>
      <div>
        <h4 class="tn-faq-q">Is my data secure?</h4>
        <p class="tn-faq-a">Yes. All data is encrypted at rest and in transit. We use enterprise-grade security protocols to ensure your workforce data remains strictly confidential.</p>
      </div>
      <div>
        <h4 class="tn-faq-q">What is the Organization plan?</h4>
        <p class="tn-faq-a">The Organization plan is built for enterprise operations needing attendance, shifts, leave policies, and custom workflows. Pricing is customized based on seat count.</p>
      </div>
    </div>
  </section>

</div>
</x-frontend-layout.app>





