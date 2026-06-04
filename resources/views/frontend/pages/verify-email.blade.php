<x-frontend-layout.app metaTitle="Email Verification — TimeNest" metaDescription="Verify your timeNest email address.">
    <section style="padding: 120px 0 80px; min-height: 60vh;">
        <div style="max-width: 520px; margin: 0 auto; padding: 0 24px;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 48px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                @if($success)
                    <div style="width: 72px; height: 72px; margin: 0 auto 24px; border-radius: 50%; background: rgba(16,185,129,0.08); display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 36px; height: 36px; color: #10b981;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h1 style="font-size: 22px; font-weight: 700; color: #0f172a; margin: 0 0 12px;">{{ $heading }}</h1>
                    <p style="font-size: 15px; color: #64748b; margin: 0 0 32px; line-height: 1.6;">{{ $message }}</p>
                    <a href="{{ config('app.url') }}"
                       style="display: inline-block; padding: 12px 28px; background-color: #4f46e5; color: #ffffff; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none;"
                       onmouseover="this.style.backgroundColor='#4338ca'" onmouseout="this.style.backgroundColor='#4f46e5'">
                        Go to TimeNest
                    </a>
                @else
                    <div style="width: 72px; height: 72px; margin: 0 auto 24px; border-radius: 50%; background: rgba(239,68,68,0.08); display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 36px; height: 36px; color: #ef4444;" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <h1 style="font-size: 22px; font-weight: 700; color: #0f172a; margin: 0 0 12px;">{{ $heading }}</h1>
                    <p style="font-size: 15px; color: #64748b; margin: 0 0 32px; line-height: 1.6;">{{ $message }}</p>
                    <a href="{{ config('app.url') }}"
                       style="display: inline-block; padding: 12px 28px; border: 1px solid #e2e8f0; border-radius: 8px; color: #0f172a; font-size: 14px; font-weight: 600; text-decoration: none;"
                       onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='transparent'">
                        Back to TimeNest
                    </a>
                @endif
            </div>
        </div>
    </section>
</x-frontend-layout.app>
