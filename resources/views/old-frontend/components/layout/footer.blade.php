<style>
.tn-footer { background-color: #0f0f1a; border-top: 1px solid rgba(255,255,255,0.05); padding: 4rem 0 2rem; }
.tn-footer-container { max-width: 1280px; margin: 0 auto; padding: 0 2rem; }
.tn-footer-grid { display: grid; gap: 3rem; grid-template-columns: 1fr; }
@media (min-width: 768px) { .tn-footer-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .tn-footer-grid { grid-template-columns: repeat(4, 1fr); } }

.tn-footer-brand { grid-column: span 1; }
@media (min-width: 1024px) { .tn-footer-brand { max-width: 280px; } }

.tn-footer-h3 { font-size: 0.75rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: #64748b; margin-bottom: 1.25rem; }
.tn-footer-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.875rem; }
.tn-footer-link { font-size: 0.875rem; color: #94a3b8; text-decoration: none; transition: color 0.2s; }
.tn-footer-link:hover { color: #f1f5f9; }
.tn-footer-social { color: #64748b; transition: color 0.2s; }
.tn-footer-social:hover { color: #f1f5f9; }

.tn-footer-bottom { margin-top: 4rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.05); display: flex; flex-direction: column; gap: 1rem; align-items: center; justify-content: space-between; }
@media (min-width: 768px) { .tn-footer-bottom { flex-direction: row; } }
</style>

<footer class="tn-footer">
    <div class="tn-footer-container">
        
        {{-- ROW 1: BRAND + NAV --}}
        <div class="tn-footer-grid">
            
            {{-- Column 1: Brand --}}
            <div class="tn-footer-brand">
                <x-frontend-base.logo size="md" variant="full" />
                <p style="margin-top: 1.5rem; font-size: 0.875rem; color: #94a3b8; line-height: 1.6;">
                    The Workforce OS for modern teams and freelancers.
                </p>
                <div style="display: flex; align-items: center; gap: 1rem; margin-top: 1.5rem;">
                    {{-- Twitter / X --}}
                    <a href="#" class="tn-footer-social" aria-label="Twitter">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    {{-- LinkedIn --}}
                    <a href="#" class="tn-footer-social" aria-label="LinkedIn">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.475-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    {{-- GitHub --}}
                    <a href="#" class="tn-footer-social" aria-label="GitHub">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                    </a>
                </div>
            </div>

            {{-- Column 2: Product --}}
            <div>
                <h3 class="tn-footer-h3">Product</h3>
                <ul class="tn-footer-list">
                    <li><a href="{{ route('frontend.product.organizations') }}" class="tn-footer-link">For Organizations</a></li>
                    <li><a href="{{ route('frontend.product.freelancers') }}" class="tn-footer-link">For Freelancers</a></li>
                    <li><a href="{{ route('frontend.product.workspace') }}" class="tn-footer-link">Freelance Workspace</a></li>
                    <li><a href="{{ route('frontend.pricing') }}" class="tn-footer-link">Pricing</a></li>
                    <li><a href="{{ route('frontend.roadmap') }}" class="tn-footer-link">Roadmap</a></li>
                    <li><a href="{{ route('frontend.ai') }}" class="tn-footer-link">AI Platform</a></li>
                </ul>
            </div>

            {{-- Column 3: Solutions --}}
            <div>
                <h3 class="tn-footer-h3">Solutions</h3>
                <ul class="tn-footer-list">
                    <li><a href="{{ route('frontend.solutions.show', 'workforce-management') }}" class="tn-footer-link">Workforce Management</a></li>
                    <li><a href="{{ route('frontend.solutions.show', 'operations-management') }}" class="tn-footer-link">Operations Management</a></li>
                    <li><a href="{{ route('frontend.solutions.show', 'financial-operations') }}" class="tn-footer-link">Financial Operations</a></li>
                    <li><a href="{{ route('frontend.solutions.show', 'freelancer-management') }}" class="tn-footer-link">Freelancer Management</a></li>
                    <li><a href="{{ route('frontend.solutions.show', 'ai-operations') }}" class="tn-footer-link">AI Operations</a></li>
                </ul>
            </div>

            {{-- Column 4: Company --}}
            <div>
                <h3 class="tn-footer-h3">Company</h3>
                <ul class="tn-footer-list">
                    <li><a href="{{ route('frontend.about') }}" class="tn-footer-link">About Us</a></li>
                    <li><a href="{{ route('frontend.careers') }}" class="tn-footer-link">Careers</a></li>
                    <li><a href="{{ route('frontend.blog.index') }}" class="tn-footer-link">Blog</a></li>
                    <li><a href="{{ route('frontend.contact') }}" class="tn-footer-link">Contact</a></li>
                    <li><a href="{{ route('frontend.docs.index') }}" class="tn-footer-link">Help Center</a></li>
                    <li><a href="{{ route('frontend.faqs.index') }}" class="tn-footer-link">FAQs</a></li>
                    <li><a href="{{ route('frontend.security') }}" class="tn-footer-link">Security</a></li>
                </ul>
            </div>
            
        </div>

        {{-- ROW 2: BOTTOM BAR --}}
        <div class="tn-footer-bottom">
            <p style="font-size: 0.875rem; color: #64748b; margin: 0;">
                &copy; {{ date('Y') }} TimeNest. All rights reserved.
            </p>
            <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.875rem; color: #64748b;">
                <a href="{{ route('frontend.legal.privacy') }}" class="tn-footer-link">Privacy Policy</a>
                <span style="color: #475569;">&middot;</span>
                <a href="{{ route('frontend.legal.terms') }}" class="tn-footer-link">Terms of Service</a>
                <span style="color: #475569;">&middot;</span>
                <a href="{{ route('frontend.legal.compliance') }}" class="tn-footer-link">Compliance</a>
            </div>
        </div>

    </div>
</footer>
