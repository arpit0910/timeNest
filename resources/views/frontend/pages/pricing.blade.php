<x-frontend-layout.app>
<x-slot name="metaTitle">Pricing — TimeNest</x-slot>

<style>
/* ═════════ BASE STYLES ═════════ */
.tn-page { background: #fafafa; color: #334155; }

/* ═════════ TYPOGRAPHY ═════════ */
.tn-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: #6366f1; }
.tn-hero-title { font-size: clamp(3rem, 5vw, 4.5rem); font-weight: 800; letter-spacing: -0.04em; color: #0f172a; line-height: 1.1; margin-bottom: 1.5rem; }
.tn-hero-subtitle { font-size: 1.25rem; color: #64748b; max-width: 600px; margin: 0 auto 3rem; line-height: 1.6; }

/* ═════════ PRICING CARDS ═════════ */
.tn-pricing-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; max-width: 1200px; margin: 0 auto; align-items: stretch; }

.tn-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 24px; padding: 2.5rem; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); display: flex; flex-direction: column; }
.tn-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -10px rgba(99,102,241,0.1); border-color: rgba(99,102,241,0.3); }

.tn-card-pro { background: #08080f; border: 1px solid rgba(99,102,241,0.4); border-radius: 24px; padding: 3rem 2.5rem; position: relative; box-shadow: 0 30px 60px -15px rgba(99,102,241,0.25); color: #ffffff; transform: scale(1.03); display: flex; flex-direction: column; z-index: 10; overflow: hidden; }

.tn-price-wrapper { margin-bottom: 2rem; }
.tn-price { font-size: 3.5rem; font-weight: 800; color: inherit; line-height: 1; margin-bottom: 0.5rem; letter-spacing: -0.04em; }
.tn-price span { font-size: 1rem; font-weight: 500; color: #94a3b8; letter-spacing: normal; }

/* ═════════ BUTTONS ═════════ */
.tn-btn-outline { display: inline-flex; align-items: center; justify-content: center; width: 100%; padding: 0.875rem 1.5rem; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; transition: all 0.2s; border: 1px solid #cbd5e1; color: #334155; background: transparent; }
.tn-btn-outline:hover { background: #f1f5f9; border-color: #94a3b8; color: #0f172a; }

.tn-btn-primary { display: inline-flex; align-items: center; justify-content: center; width: 100%; padding: 0.875rem 1.5rem; border-radius: 12px; font-weight: 700; font-size: 1rem; text-decoration: none; transition: all 0.2s; background: #6366f1; color: #ffffff; border: none; box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
.tn-btn-primary:hover { background: #4f46e5; transform: translateY(-1px); box-shadow: 0 6px 16px rgba(99,102,241,0.4); }

/* ═════════ FEATURE LISTS ═════════ */
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

/* ═════════ COMPARISON TABLE ═════════ */
.tn-table-wrapper { max-width: 1100px; margin: 5rem auto 2rem; background: #ffffff; border-radius: 24px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05); }
.tn-table { width: 100%; border-collapse: collapse; text-align: left; }
.tn-table th { padding: 1.5rem; background: #f8fafc; font-weight: 700; color: #0f172a; font-size: 1rem; border-bottom: 2px solid #e2e8f0; }
.tn-table td { padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; color: #475569; font-size: 0.95rem; }
.tn-table tr:last-child td { border-bottom: none; }
.tn-table td.text-center, .tn-table th.text-center { text-align: center; }

/* ═════════ FAQ ═════════ */
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
  <section style="padding: 0 2rem 5rem; position: relative; z-index: 10;">
    <div class="tn-pricing-grid tn-3col">
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;max-width:1100px;margin:0 auto;" class="tn-pricing-grid tn-3col">
        {{-- FOR FREELANCERS --}}
        <div class="tn-card" style="padding:2.5rem;display:flex;flex-direction:column;gap:2rem;">
          <div>
            <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#64748b;">For Freelancers</span>
            <div style="display:flex;align-items:baseline;gap:4px;margin-top:0.75rem;">
              <span class="tn-price-num">&#8377;0</span>
              <span style="color:#475569;font-size:0.9rem;">/month</span>
            </div>
            <p style="color:#64748b; font-size:0.9rem; margin-top:1rem; line-height:1.5; height:60px;">Everything a solo freelancer needs to manage clients, revenue, and projects from one dashboard. Forever free.</p>
          </div>
          <ul class="tn-feat-list" style="flex:1;">
            @foreach(['Client CRM & Lead Tracking', 'Professional Invoicing', 'Quotations & Proposals', 'Revenue Analytics', 'Project Management', 'Task Tracking & Kanban', 'Document Management', 'AI Revenue Forecasting'] as $f)
            <li>
              <svg class="tn-check" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              {{ `$f }}
            </li>
            @endforeach
          </ul>
          <a href="/register" class="tn-btn-ghost" style="text-align:center;justify-content:center;">Start Freelancing Free</a>
        </div>
        
        {{-- FREELANCE WORKSPACE --}}
        <div class="tn-card-glow" style="padding:2.5rem;display:flex;flex-direction:column;gap:2rem;position:relative;">
          <span style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:#4f46e5;color:#fff;font-size:0.65rem;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;padding:0.3rem 1rem;border-radius:999px;white-space:nowrap;">Most Popular</span>
          <div>
            <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#6366f1;">Freelance Workspace</span>
            <div style="display:flex;align-items:baseline;gap:4px;margin-top:0.75rem;">
              <span class="tn-price-num">&#8377;999</span>
              <span style="color:#475569;font-size:0.9rem;">/workspace/mo</span>
            </div>
            <p style="color:#64748b; font-size:0.9rem; margin-top:1rem; line-height:1.5; height:60px;">A collaborative workspace for freelance teams, agencies, and studios. Share projects without corporate overhead.</p>
          </div>
          <ul class="tn-feat-list" style="flex:1;">
            @foreach(['Collaborator Management', 'Shared Projects & Files', 'Shared Client Billing', 'Workspace Analytics', 'Team Utilization Tracking', 'Collaborative Reporting', 'Agency Workflows', 'Shared Documents'] as $f)
            <li>
              <svg class="tn-check" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              {{ `$f }}
            </li>
            @endforeach
          </ul>
          <a href="/register" class="tn-btn-primary" style="justify-content:center;">Launch Your Workspace</a>
        </div>
  
        {{-- FOR ORGANIZATIONS --}}
        <div class="tn-card" style="padding:2.5rem;display:flex;flex-direction:column;gap:2rem;">
          <div>
            <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#64748b;">For Organizations</span>
            <div style="display:flex;align-items:baseline;gap:4px;margin-top:0.75rem;">
              <span class="tn-price-num" style="font-size:2rem;">Contact Sales</span>
            </div>
            <p style="color:#64748b; font-size:0.9rem; margin-top:1rem; line-height:1.5; height:60px;">Complete workforce and operations management for companies. Unify HR, attendance, shifts, and workflows.</p>
          </div>
          <ul class="tn-feat-list" style="flex:1;">
            @foreach(['Employee Directory & Profiles', 'Attendance Tracking & GPS', 'Shift Scheduling & Rostering', 'Departments & Teams', 'Roles & Permissions', 'Multi-Level Approvals', 'Workforce Analytics', 'Compliance Monitoring'] as $f)
            <li>
              <svg class="tn-check" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              {{ `$f }}
            </li>
            @endforeach
          </ul>
          <a href="{{ route('frontend.book-demo') ?? '#' }}" class="tn-btn-ghost" style="text-align:center;justify-content:center;">Book Organization Demo</a>
        </div>
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



