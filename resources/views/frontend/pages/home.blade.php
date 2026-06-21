<x-frontend-layout.app>
<x-slot name="metaTitle">TimeNest — The Workforce OS Your Team Actually Uses</x-slot>

<style>
/* ── ROOT DARK THEME ── */
.tn-page { background: #ffffff; color: #334155; }
html, body { background-color: #0f0f1a !important; color: #334155; }

/* ── TYPOGRAPHY ── */
.tn-eyebrow { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; color: #6366f1; }
.tn-h1 { font-size: clamp(2.5rem, 6vw, 4.5rem); font-weight: 800; line-height: 1.05; letter-spacing: -0.03em; color: #0f172a; }
.tn-h2 { font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 700; line-height: 1.1; letter-spacing: -0.02em; color: #0f172a; }
.tn-h3 { font-size: 1.125rem; font-weight: 700; color: #0f172a; }
.tn-body { font-size: 1rem; line-height: 1.7; color: #475569; }
.tn-muted { font-size: 0.875rem; color: #94a3b8; }
.tn-grad { background: linear-gradient(135deg, #312e81 0%, #4f46e5 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

/* ── LAYOUT ── */
.tn-section { padding: 6rem 0; }
.tn-section-sm { padding: 3rem 0; }
.tn-container { max-width: 1280px; margin: 0 auto; padding: 0 2rem; }

/* ── SURFACES ── */
.tn-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; }
.tn-card:hover { border-color: rgba(99,102,241,0.4); background: #f1f5f9; }
.tn-card-glow { background: #f8fafc; border: 1px solid rgba(99,102,241,0.5); border-radius: 16px; box-shadow: 0 0 60px rgba(99,102,241,0.1), 0 8px 32px rgba(0,0,0,0.06); }
.tn-divider { border-color: rgba(255,255,255,0.06); }

/* ── BUTTONS ── */
.tn-btn-primary {
  display: inline-flex; align-items: center; gap: 0.5rem;
  padding: 0.875rem 1.75rem; border-radius: 12px;
  background: #4f46e5; color: #fff; font-weight: 700; font-size: 0.9rem;
  letter-spacing: 0.01em; text-decoration: none;
  box-shadow: 0 0 0 1px #4f46e5, 0 4px 24px rgba(79,70,229,0.5), 0 1px 2px rgba(0,0,0,0.4);
  transition: all 0.15s ease;
  border: none; cursor: pointer;
}
.tn-btn-primary:hover { background: #6366f1; box-shadow: 0 0 0 1px #6366f1, 0 4px 32px rgba(99,102,241,0.65), 0 1px 2px rgba(0,0,0,0.4); transform: translateY(-1px); }

.tn-btn-ghost-dark {
  display: inline-flex; align-items: center; gap: 0.5rem;
  padding: 0.875rem 1.75rem; border-radius: 12px;
  background: rgba(255,255,255,0.04); color: #cbd5e1; font-weight: 600; font-size: 0.9rem;
  text-decoration: none; border: 1px solid rgba(255,255,255,0.1);
  transition: all 0.15s ease; cursor: pointer;
}
.tn-btn-ghost-dark:hover { background: rgba(255,255,255,0.08); border-color: rgba(99,102,241,0.5); color: #f1f5f9; }

.tn-btn-ghost {
  display: inline-flex; align-items: center; gap: 0.5rem;
  padding: 0.875rem 1.75rem; border-radius: 12px;
  background: transparent; color: #475569; font-weight: 600; font-size: 0.9rem;
  text-decoration: none; border: 1px solid #cbd5e1;
  transition: all 0.15s ease; cursor: pointer;
}
.tn-btn-ghost:hover { background: #f1f5f9; border-color: #94a3b8; color: #0f172a; }

.tn-btn-white {
  display: inline-flex; align-items: center; gap: 0.5rem;
  padding: 1rem 2rem; border-radius: 12px;
  background: #fff; color: #0f0f1a; font-weight: 700; font-size: 0.95rem;
  text-decoration: none; border: none;
  box-shadow: 0 4px 16px rgba(0,0,0,0.3);
  transition: all 0.15s ease; cursor: pointer;
}
.tn-btn-white:hover { background: #e0e7ff; transform: translateY(-1px); }

/* ── BADGE ── */
.tn-badge { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.375rem 1rem; border-radius: 999px; background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.3); color: #a5b4fc; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; }
.tn-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: #6366f1; box-shadow: 0 0 8px rgba(99,102,241,0.8); animation: pulse 2s infinite; }

/* ── GRID BG ── */
.tn-grid-bg {
  background-image: linear-gradient(rgba(0,0,0,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,0.04) 1px, transparent 1px);
  background-size: 64px 64px;
}

/* ── GLOW ORBS ── */
.tn-glow-top { position: absolute; top: -200px; left: 50%; transform: translateX(-50%); width: 900px; height: 600px; background: radial-gradient(ellipse at center, rgba(99,102,241,0.18) 0%, transparent 65%); pointer-events: none; }
.tn-glow-brand { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 600px; height: 400px; background: radial-gradient(ellipse at center, rgba(99,102,241,0.1) 0%, transparent 70%); pointer-events: none; }

/* ── ICON CHIP ── */
.tn-icon-chip { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
.tn-icon-indigo { background: rgba(99,102,241,0.12); color: #818cf8; }
.tn-icon-violet { background: rgba(139,92,246,0.12); color: #a78bfa; }
.tn-icon-amber { background: rgba(245,158,11,0.12); color: #fbbf24; }
.tn-icon-emerald { background: rgba(16,185,129,0.12); color: #34d399; }

/* ── ANIMATIONS ── */
@keyframes pulse { 0%,100%{opacity:1}50%{opacity:0.4} }
@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
@keyframes ping-slow { 0%{transform:scale(1);opacity:0.6} 100%{transform:scale(1.8);opacity:0} }
@keyframes bar-grow { from{transform:scaleY(0);opacity:0} to{transform:scaleY(1);opacity:1} }
.tn-float { animation: float 5s ease-in-out infinite; }
.tn-ping { animation: ping-slow 2.5s ease-out infinite; }
.tn-bar { transform-origin: bottom; animation: bar-grow 0.6s ease-out forwards; }

/* ── STAR ── */
.tn-star { width:16px;height:16px;color:#818cf8;fill:#818cf8; }

/* ── FEATURE GRID ── */
.tn-feat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1px; background: #e2e8f0; border-radius: 16px; overflow: hidden; }
.tn-feat-item { background: #f8fafc; padding: 2rem; transition: background 0.2s; }
.tn-feat-item:hover { background: #f1f5f9; }

/* ── TESTIMONIAL STARS ── */
.tn-stars { display:flex;gap:3px;margin-bottom:1rem; }

/* ── PRICING ── */
.tn-price-num { font-size: 3.5rem; font-weight: 800; color: #0f172a; line-height: 1; }
.tn-check { width: 18px; height: 18px; color: #6366f1; flex-shrink: 0; margin-top: 2px; }

/* ── CTA OVERRIDES ── */
@media (max-width: 1023px) {
    .tn-cta-responsive { grid-template-columns: 1fr !important; padding: 3rem 1.5rem !important; text-align: center; }
    .tn-cta-content { display: flex; flex-direction: column; align-items: center; text-align: center !important; }
    .tn-cta-visual { display: none !important; }
    .tn-cta-buttons { justify-content: center; }
}

.tn-feat-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.75rem; }
.tn-feat-list li { display: flex; align-items: center; gap: 0.625rem; font-size: 0.9rem; color: #475569; }

/* ── RESPONSIVE ── */
@media(max-width:768px){
  .tn-hero-grid{display:block !important;}
  .tn-hero-visual{margin-top:3rem;}
  .tn-2col{display:block !important;}
  .tn-2col > * { margin-bottom: 3rem; }
  .tn-3col{grid-template-columns:1fr !important;}
  .tn-4col{grid-template-columns:1fr 1fr !important;}
  .tn-pricing-grid{grid-template-columns:1fr !important;}
}
</style>

<div class="tn-page">

{{-- ═══════════ SECTION 1: HERO ═══════════ --}}
<section style="background:#ffffff;position:relative;min-height:100vh;display:flex;align-items:center;overflow:hidden;" class="tn-grid-bg">
  <div class="tn-glow-top"></div>
  <div class="tn-container" style="position:relative;z-index:1;padding-top:7rem;padding-bottom:5rem;">
    <div class="tn-hero-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;">

      {{-- LEFT: COPY --}}
      <div>
        <div class="tn-badge" style="margin-bottom:1.5rem;">
          <span class="tn-badge-dot"></span>
          Now in Early Access · Join 200+ teams
        </div>
        <h1 class="tn-h1" style="margin-bottom:1.5rem;">
          The Workforce OS<br>
          <span class="tn-grad">Your Team Actually Uses</span>
        </h1>
        <p class="tn-body" style="max-width:480px;margin-bottom:2.5rem;">
          TimeNest brings attendance, time logs, leaves, shifts, and AI insights into one unified platform — built for freelancers, growing teams, and enterprise organizations.
        </p>
        <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;margin-bottom:2rem;">
          <a href="/register" class="tn-btn-primary">
            Start Free Trial
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
          </a>
          <a href="#features-section" class="tn-btn-ghost">
            See How It Works
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </a>
        </div>
        <p class="tn-muted">✓ Trusted by teams in 12+ countries &nbsp;·&nbsp; ✓ No credit card required</p>
      </div>

      {{-- RIGHT: DASHBOARD MOCKUP --}}
      <div class="tn-hero-visual tn-float">
        <div class="tn-card" style="padding:1.5rem;box-shadow:0 0 80px rgba(99,102,241,0.12);">
          {{-- Header bar --}}
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
            <span style="font-size:0.8rem;font-weight:700;color:#0f172a;">TimeNest Dashboard</span>
            <div style="width:28px;height:28px;border-radius:50%;background:#4f46e5;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;color:#fff;">A</div>
          </div>
          {{-- Stat cards --}}
          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:0.75rem;margin-bottom:1.25rem;">
            @foreach([['142','Present','#6366f1'],['8','On Leave','#f59e0b'],['3','Late','#ef4444']] as [$num,$label,$color])
            <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:10px;padding:0.875rem;">
              <div style="font-size:1.4rem;font-weight:800;color:{{ $color }};line-height:1;">{{ $num }}</div>
              <div style="font-size:0.65rem;color:#64748b;margin-top:0.25rem;">{{ $label }}</div>
            </div>
            @endforeach
          </div>
          {{-- Bar chart --}}
          <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:10px;padding:1rem;margin-bottom:0.75rem;">
            <div style="font-size:0.65rem;color:#475569;margin-bottom:0.75rem;font-weight:600;">WEEKLY ATTENDANCE</div>
            <div style="display:flex;align-items:flex-end;gap:6px;height:60px;">
              @foreach([['M',70],['T',90],['W',60],['T',85],['F',40],['S',55],['S',75]] as [$d,$h])
              <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;height:100%;">
                <div class="tn-bar" style="width:100%;border-radius:4px 4px 0 0;background:linear-gradient(180deg,#6366f1,#4f46e5);height:{{ $h }}%;animation-delay:{{ $loop->index * 0.08 }}s;"></div>
                <span style="font-size:0.55rem;color:#475569;">{{ $d }}</span>
              </div>
              @endforeach
            </div>
          </div>
          {{-- Status --}}
          <div style="display:flex;align-items:center;gap:0.5rem;">
            <span style="width:6px;height:6px;border-radius:50%;background:#34d399;box-shadow:0 0 8px rgba(52,211,153,0.8);animation:pulse 2s infinite;"></span>
            <span style="font-size:0.7rem;color:#475569;">Last sync: just now</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ═══════════ SECTION 2: TRUST BAR ═══════════ --}}
<section class="tn-section-sm" style="border-top:1px solid #e2e8f0;border-bottom:1px solid #e2e8f0;background:#fafafa;">
  <div class="tn-container">
    <p class="tn-muted" style="text-align:center;letter-spacing:0.1em;text-transform:uppercase;font-size:0.7rem;font-weight:600;margin-bottom:2rem;">Trusted by teams at</p>
    <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:3rem;">
      @foreach(['Acumen','Driftwork','Stacklane','Veloria','Nexbridge','Orbitops'] as $co)
      <span style="font-size:1rem;font-weight:700;color:#94a3b8;letter-spacing:-0.01em;cursor:default;transition:color 0.2s;" onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">{{ $co }}</span>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══════════ SECTION 3: PLATFORM OVERVIEW ═══════════ --}}
<section id="features-section" class="tn-section">
  <div class="tn-container">
    <div style="text-align:center;margin-bottom:4rem;">
      <div class="tn-eyebrow" style="margin-bottom:0.75rem;">THE PLATFORM</div>
      <h2 class="tn-h2">Everything workforce.<br><span class="tn-grad">Nothing wasted.</span></h2>
      <p class="tn-body" style="max-width:560px;margin:1.25rem auto 0;">One platform to manage your people, time, and operations — whether you're a solo freelancer or running a 500-person company.</p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;" class="tn-3col">
      @foreach([
        ['For Organizations','Enterprise Workforce Control','Manage multi-department teams with granular role permissions, geo-fenced attendance, shift policies, and automated approval workflows.','Explore for Organizations','frontend.product.organizations','indigo','M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
        ['For Freelancers','Solo & Freelance Ready','Track client hours, log billable time, manage your own leave — all from one clean workspace that grows with your workload.','Explore for Freelancers','frontend.product.freelancers','violet','M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ['For Teams','Freelance Team Workspace','Collaborate with your crew — shared attendance tracking, team timesheets, member directories, and unified reporting.','Explore Workspace','frontend.product.workspace','amber','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
      ] as [$eyebrow,$title,$body,$cta,$route,$color,$icon])
      <div class="tn-card" style="padding:2rem;display:flex;flex-direction:column;gap:1.25rem;transition:all 0.2s;">
        <div class="tn-icon-chip tn-icon-{{ $color }}">
          <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/></svg>
        </div>
        <div>
          <div class="tn-eyebrow" style="margin-bottom:0.4rem;">{{ $eyebrow }}</div>
          <div class="tn-h3">{{ $title }}</div>
        </div>
        <p class="tn-body" style="font-size:0.9rem;">{{ $body }}</p>
        <a href="{{ route($route) }}" style="margin-top:auto;font-size:0.85rem;font-weight:700;color:#818cf8;text-decoration:none;display:inline-flex;align-items:center;gap:0.375rem;">
          {{ $cta }}
          <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══════════ SECTION 4A: FEATURE — ATTENDANCE ═══════════ --}}
<section class="tn-section" style="background:#f8fafc;">
  <div class="tn-container">
    <div class="tn-2col" style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;">
      <div>
        <div class="tn-eyebrow" style="margin-bottom:0.75rem;">ATTENDANCE</div>
        <h2 class="tn-h2" style="margin-bottom:1.25rem;">Clock in. Know who's<br>where. Always.</h2>
        <p class="tn-body" style="margin-bottom:2rem;">Real-time attendance tracking with geo-fence enforcement. Set per-branch radius rules — strict block or flexible flagging. Every clock-in is stamped with location, device, and time.</p>
        <a href="{{ route('frontend.feature.show', ['category'=>'workforce','slug'=>'attendance-management']) }}" class="tn-btn-ghost" style="width:fit-content;">Learn More →</a>
      </div>
      <div>
        <div class="tn-card" style="padding:2.5rem;text-align:center;">
          <div style="position:relative;width:180px;height:180px;margin:0 auto 2rem;display:flex;align-items:center;justify-content:center;">
            <div class="tn-ping" style="position:absolute;width:180px;height:180px;border-radius:50%;border:1px solid rgba(99,102,241,0.25);"></div>
            <div style="position:absolute;width:130px;height:130px;border-radius:50%;border:1px solid rgba(99,102,241,0.4);"></div>
            <div style="position:absolute;width:80px;height:80px;border-radius:50%;border:1px solid rgba(99,102,241,0.6);"></div>
            <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#4f46e5);display:flex;align-items:center;justify-content:center;box-shadow:0 0 30px rgba(99,102,241,0.6);">
              <svg width="22" height="22" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
          </div>
          <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:1rem 1.25rem;display:flex;align-items:center;gap:0.875rem;text-align:left;">
            <span style="width:8px;height:8px;border-radius:50%;background:#34d399;box-shadow:0 0 10px rgba(52,211,153,0.8);flex-shrink:0;"></span>
            <div style="flex:1;">
              <div style="font-size:0.85rem;font-weight:700;color:#0f172a;">Checked In</div>
              <div style="font-size:0.75rem;color:#475569;margin-top:2px;">09:02 AM · Mumbai Branch</div>
            </div>
            <span style="font-size:0.7rem;font-weight:700;color:#34d399;background:rgba(52,211,153,0.1);padding:0.25rem 0.625rem;border-radius:999px;">On Time</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ═══════════ SECTION 4B: FEATURE — LEAVE ═══════════ --}}
<section class="tn-section" style="background:#ffffff;">
  <div class="tn-container">
    <div class="tn-2col" style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;">
      <div>
        {{-- Calendar visual --}}
        <div class="tn-card" style="padding:2rem;">
          <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
            <span style="font-size:0.9rem;font-weight:700;color:#0f172a;">June 2025</span>
            <span style="font-size:0.75rem;color:#475569;">Leave Calendar</span>
          </div>
          {{-- Day headers --}}
          <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px;margin-bottom:4px;">
            @foreach(['M','T','W','T','F','S','S'] as $d)
            <div style="text-align:center;font-size:0.65rem;font-weight:700;color:#334155;padding-bottom:4px;">{{ $d }}</div>
            @endforeach
          </div>
          {{-- Days grid --}}
          <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:4px;">
            @php
              $approved = [10,11,12,13];
              $pending  = [17];
              $rejected = [24];
            @endphp
            @for($day = 1; $day <= 30; $day++)
              @if(in_array($day, $approved))
                <div style="text-align:center;padding:5px 2px;font-size:0.72rem;font-weight:700;color:#818cf8;background:rgba(99,102,241,0.15);border-radius:6px;">{{ $day }}</div>
              @elseif(in_array($day, $pending))
                <div style="text-align:center;padding:5px 2px;font-size:0.72rem;font-weight:700;color:#fbbf24;background:rgba(245,158,11,0.15);border-radius:6px;">{{ $day }}</div>
              @elseif(in_array($day, $rejected))
                <div style="text-align:center;padding:5px 2px;font-size:0.72rem;font-weight:700;color:#f87171;background:rgba(239,68,68,0.15);border-radius:6px;">{{ $day }}</div>
              @else
                <div style="text-align:center;padding:5px 2px;font-size:0.72rem;color:#94a3b8;">{{ $day }}</div>
              @endif
            @endfor
          </div>
          <div style="display:flex;gap:1.25rem;margin-top:1.25rem;padding-top:1rem;border-top:1px solid rgba(255,255,255,0.05);">
            <span style="display:flex;align-items:center;gap:0.4rem;font-size:0.72rem;color:#64748b;"><span style="width:8px;height:8px;border-radius:50%;background:#818cf8;"></span>Approved</span>
            <span style="display:flex;align-items:center;gap:0.4rem;font-size:0.72rem;color:#64748b;"><span style="width:8px;height:8px;border-radius:50%;background:#fbbf24;"></span>Pending</span>
            <span style="display:flex;align-items:center;gap:0.4rem;font-size:0.72rem;color:#64748b;"><span style="width:8px;height:8px;border-radius:50%;background:#f87171;"></span>Rejected</span>
          </div>
        </div>
      </div>
      <div>
        <div class="tn-eyebrow" style="margin-bottom:0.75rem;">LEAVE MANAGEMENT</div>
        <h2 class="tn-h2" style="margin-bottom:1.25rem;">Leave requests that<br>don't need chasing.</h2>
        <p class="tn-body" style="margin-bottom:2rem;">Configurable leave policies per organization. Auto-approval or multi-level approval flows. Employees see their balance in real time. Managers get notified instantly.</p>
        <a href="{{ route('frontend.feature.show', ['category'=>'workforce','slug'=>'leave-management']) }}" class="tn-btn-ghost" style="width:fit-content;">Learn More →</a>
      </div>
    </div>
  </div>
</section>

{{-- ═══════════ SECTION 4C: FEATURE — AI ═══════════ --}}
<section class="tn-section" style="background:#f8fafc;">
  <div class="tn-container">
    <div class="tn-2col" style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;">
      <div>
        <div class="tn-eyebrow" style="margin-bottom:0.75rem;">AI INSIGHTS</div>
        <h2 class="tn-h2" style="margin-bottom:1.25rem;">Your workforce data,<br>finally making sense.</h2>
        <p class="tn-body" style="margin-bottom:2rem;">TimeNest AI surfaces attendance anomalies, flags unusual patterns, forecasts leave conflicts, and gives managers the context they need — without manual reports.</p>
        <a href="{{ route('frontend.ai') }}" class="tn-btn-ghost" style="width:fit-content;">Explore AI Platform →</a>
      </div>
      <div>
        <div class="tn-card" style="padding:2rem;">
          <div style="font-size:0.7rem;font-weight:700;color:#475569;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:1rem;">Weekly Attendance Rate</div>
          <div style="display:flex;align-items:flex-end;gap:8px;height:100px;margin-bottom:1.25rem;">
            @foreach([['M',65],['T',80],['W',55],['T',90],['F',45],['S',70],['S',85]] as $i => [$d,$h])
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px;height:100%;">
              <div class="tn-bar" style="width:100%;border-radius:5px 5px 0 0;background:linear-gradient(180deg,#818cf8,#4f46e5);height:{{ $h }}%;animation-delay:{{ $i * 0.07 }}s;"></div>
              <span style="font-size:0.6rem;color:#475569;font-weight:600;">{{ $d }}</span>
            </div>
            @endforeach
          </div>
          <div style="background:rgba(99,102,241,0.08);border:1px solid rgba(99,102,241,0.2);border-radius:12px;padding:1rem;display:flex;align-items:flex-start;gap:0.75rem;">
            <div style="width:28px;height:28px;border-radius:8px;background:#4f46e5;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px;">
              <svg width="14" height="14" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
              <div style="font-size:0.65rem;font-weight:800;color:#6366f1;letter-spacing:0.1em;text-transform:uppercase;margin-bottom:0.25rem;">AI Insight</div>
              <div style="font-size:0.85rem;color:#475569;line-height:1.5;">Attendance dipped 18% this Friday — likely due to 3 overlapping leave requests.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ═══════════ SECTION 5: FEATURE GRID ═══════════ --}}
<section class="tn-section" style="background:#ffffff;">
  <div class="tn-container">
    <div style="text-align:center;margin-bottom:4rem;">
      <div class="tn-eyebrow" style="margin-bottom:0.75rem;">BUILT FOR REAL TEAMS</div>
      <h2 class="tn-h2">Everything you need.<br><span class="tn-grad">Nothing you don't.</span></h2>
    </div>
    <div class="tn-feat-grid">
      @foreach([
        ['Geo-Fence Attendance','Branch-level radius enforcement with strict or flexible modes.','M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'],
        ['Shift Management','Build rotating shifts, assign teams, track adherence automatically.','M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['Leave Policies','Carry-forward rules, leave types, accrual logic — fully configurable.','M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
        ['Multi-Level Approvals','Auto, single, or multi-step approval chains per policy.','M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['Employee Directory','Searchable org-wide directory with roles, departments, and status.','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['Time Logs','Billable hour tracking for freelancers and project-based teams.','M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['Role Permissions','Granular permission control without writing a single line of code.','M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z'],
        ['Audit Trail','Every action logged. Every change tracked. Full accountability.','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
      ] as [$title,$body,$icon])
      <div class="tn-feat-item">
        <div class="tn-icon-chip tn-icon-indigo" style="margin-bottom:1rem;">
          <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="{{ $icon }}"/></svg>
        </div>
        <div class="tn-h3" style="font-size:0.95rem;margin-bottom:0.5rem;">{{ $title }}</div>
        <p class="tn-body" style="font-size:0.85rem;">{{ $body }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══════════ SECTION 6: AI TEASER ═══════════ --}}
<section class="tn-section" style="background:#f1f5f9;position:relative;overflow:hidden;">
  <div class="tn-glow-brand"></div>
  <div class="tn-container" style="position:relative;z-index:1;text-align:center;">
    <div class="tn-eyebrow" style="margin-bottom:0.75rem;">AI PLATFORM</div>
    <h2 class="tn-h2" style="margin-bottom:1.25rem;">Your workforce,<br><span class="tn-grad">intelligently managed.</span></h2>
    <p class="tn-body" style="max-width:520px;margin:0 auto 2.5rem;">TimeNest AI doesn't just show you data — it tells you what it means and what to do next.</p>
    <div style="display:flex;flex-wrap:wrap;gap:0.75rem;justify-content:center;margin-bottom:2.5rem;">
      @foreach(['Attendance Anomaly Detection','Leave Conflict Forecasting','Productivity Pattern Analysis','AI Executive Dashboard','Fraud Detection'] as $pill)
      <span style="padding:0.5rem 1rem;border-radius:999px;background:rgba(99,102,241,0.1);border:1px solid rgba(99,102,241,0.25);color:#a5b4fc;font-size:0.8rem;font-weight:600;">{{ $pill }}</span>
      @endforeach
    </div>
    <a href="{{ route('frontend.ai') }}" class="tn-btn-ghost">Explore the AI Platform →</a>
  </div>
</section>

{{-- ═══════════ SECTION 7: TESTIMONIALS ═══════════ --}}
<section class="tn-section" style="background:#ffffff;">
  <div class="tn-container">
    <div style="text-align:center;margin-bottom:4rem;">
      <div class="tn-eyebrow" style="margin-bottom:0.75rem;">WHAT TEAMS SAY</div>
      <h2 class="tn-h2">Built for the teams<br>who showed up.</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;" class="tn-3col">
      @foreach([
        ['"We went from messy spreadsheets to a fully automated attendance and leave system in under a week. TimeNest just works."','Riya Sharma','HR Manager, Acumen Corp','RS','#4f46e5'],
        ['"As a freelancer managing multiple clients, TimeNest\'s time log and workspace features saved me hours every week."','Marcus Webb','Independent Consultant','MW','#7c3aed'],
        ['"The multi-level approval workflow is exactly what our 200-person team needed. No more chasing managers on Slack."','Priya Nair','COO, Stacklane','PN','#b45309'],
      ] as [$quote,$name,$role,$initials,$avatarBg])
      <div class="tn-card" style="padding:2rem;display:flex;flex-direction:column;gap:1.5rem;">
        <div class="tn-stars">
          @for($s=0;$s<5;$s++)
          <svg class="tn-star" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          @endfor
        </div>
        <p style="font-size:0.95rem;color:#475569;line-height:1.7;font-style:italic;flex:1;">{{ $quote }}</p>
        <div style="display:flex;align-items:center;gap:0.875rem;">
          <div style="width:40px;height:40px;border-radius:50%;background:{{ $avatarBg }};display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:800;color:#fff;flex-shrink:0;">{{ $initials }}</div>
          <div>
            <div style="font-size:0.9rem;font-weight:700;color:#0f172a;">{{ $name }}</div>
            <div style="font-size:0.78rem;color:#94a3b8;">{{ $role }}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══════════ SECTION 8: PRICING TEASER ═══════════ --}}
<section class="tn-section" style="background:#f8fafc;">
  <div class="tn-container">
    <div style="text-align:center;margin-bottom:3.5rem;">
      <div class="tn-eyebrow" style="margin-bottom:0.75rem;">PRICING</div>
      <h2 class="tn-h2">Start free.<br>Scale when ready.</h2>
      <p class="tn-body" style="max-width:440px;margin:1.25rem auto 0;">No credit card required. No hidden fees. Full access to core features on the free plan.</p>
    </div>
    
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
            @foreach(['Client CRM & Lead Tracking', 'Professional Invoicing', 'Quotations & Proposals', 'Revenue Analytics', 'Project Management', 'Task Tracking & Kanban', 'Document Management', 'AI Revenue Forecasting'] as )
            <li>
              <svg class="tn-check" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              {{ $f }}
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
            @foreach(['Collaborator Management', 'Shared Projects & Files', 'Shared Client Billing', 'Workspace Analytics', 'Team Utilization Tracking', 'Collaborative Reporting', 'Agency Workflows', 'Shared Documents'] as )
            <li>
              <svg class="tn-check" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              {{ $f }}
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
            @foreach(['Employee Directory & Profiles', 'Attendance Tracking & GPS', 'Shift Scheduling & Rostering', 'Departments & Teams', 'Roles & Permissions', 'Multi-Level Approvals', 'Workforce Analytics', 'Compliance Monitoring'] as )
            <li>
              <svg class="tn-check" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
              {{ $f }}
            </li>
            @endforeach
          </ul>
          <a href="{{ route('frontend.book-demo') ?? '#' }}" class="tn-btn-ghost" style="text-align:center;justify-content:center;">Book Organization Demo</a>
        </div>
      </div>

</section>

</div>
</x-frontend-layout.app>


