<x-frontend-layout.app metaTitle="Accept Invitation — TimeNest" metaDescription="Accept your invitation to join a workspace on TimeNest.">
    <section style="padding: 120px 0 80px; min-height: 60vh;">
        <div style="max-width: 520px; margin: 0 auto; padding: 0 24px;">

            {{-- Error State --}}
            @if(isset($error) && $error)
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 48px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
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
                </div>

            {{-- Success State --}}
            @elseif(isset($success) && $success)
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 48px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
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
                </div>

            {{-- Accept Form --}}
            @else
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">

                    {{-- Header --}}
                    <div style="background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%); padding: 28px 32px; text-align: center;">
                        <h1 style="font-size: 24px; font-weight: 700; color: #ffffff; margin: 0;">You're Invited!</h1>
                    </div>

                    <div style="padding: 32px;">

                        {{-- Organization Info --}}
                        <div class="mb-6 flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-1">Inviting Organization</div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white text-center">
                                {{ $invitation->organization->legal_name }}
                            </div>
                            <p style="font-size: 15px; color: #64748b; margin: 0;">
                                Join as <span style="font-weight: 600; color: #0f172a;">{{ $invitation->role->description ?? $invitation->role->name }}</span>
                            </p>
                        </div>

                        {{-- Details --}}
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                <span style="font-size: 13px; color: #64748b;">Email</span>
                                <span style="font-size: 13px; font-weight: 600; color: #0f172a;">{{ $invitation->email }}</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span style="font-size: 13px; color: #64748b;">Expires</span>
                                <span style="font-size: 13px; color: #0f172a;">{{ $invitation->expires_at->format('M j, Y g:i a') }}</span>
                            </div>
                        </div>

                        {{-- Error Message --}}
                        @if(isset($loginError))
                            <div style="background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.15); border-radius: 10px; padding: 14px 18px; margin-bottom: 20px;">
                                <p style="font-size: 14px; color: #dc2626; font-weight: 500; margin: 0;">{{ $loginError }}</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('invitations.accept.web') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $rawToken }}">

                            @if($userExists)
                                {{-- Existing User --}}
                                <div style="background: rgba(16,185,129,0.05); border: 1px solid rgba(16,185,129,0.15); border-radius: 10px; padding: 14px 18px; margin-bottom: 20px;">
                                    <p style="font-size: 14px; color: #334155; margin: 0;">
                                        <strong style="color: #0f172a;">✅ Account found.</strong>
                                        Enter your password to accept.
                                    </p>
                                </div>

                                <div style="margin-bottom: 20px;">
                                    <label for="password" style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 6px;">Password</label>
                                    <input type="password" name="password" id="password" required
                                           style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; color: #0f172a; outline: none; box-sizing: border-box;"
                                           onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                                           onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"
                                           placeholder="Enter your account password">
                                </div>

                            @else
                                {{-- New User --}}
                                <div style="background: rgba(245,158,11,0.05); border: 1px solid rgba(245,158,11,0.15); border-radius: 10px; padding: 14px 18px; margin-bottom: 20px;">
                                    <p style="font-size: 14px; color: #334155; margin: 0;">
                                        <strong style="color: #0f172a;">📝 New account.</strong>
                                        Set up your profile to join.
                                    </p>
                                </div>

                                <div style="margin-bottom: 16px;">
                                    <label for="name" style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 6px;">Full Name</label>
                                    <input type="text" name="name" id="name" required minlength="2" maxlength="100"
                                           value="{{ old('name') }}"
                                           style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; color: #0f172a; outline: none; box-sizing: border-box;"
                                           onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                                           onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"
                                           placeholder="Your full name">
                                </div>

                                <div style="margin-bottom: 16px;">
                                    <label for="password" style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 6px;">Password</label>
                                    <input type="password" name="password" id="password" required minlength="8"
                                           style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; color: #0f172a; outline: none; box-sizing: border-box;"
                                           onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                                           onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"
                                           placeholder="Minimum 8 characters">
                                </div>

                                <div style="margin-bottom: 20px;">
                                    <label for="password_confirmation" style="display: block; font-size: 14px; font-weight: 500; color: #0f172a; margin-bottom: 6px;">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                                           style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; color: #0f172a; outline: none; box-sizing: border-box;"
                                           onfocus="this.style.borderColor='#4f46e5';this.style.boxShadow='0 0 0 3px rgba(79,70,229,0.1)'"
                                           onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'"
                                           placeholder="Repeat your password">
                                </div>
                            @endif

                            {{-- Validation Errors --}}
                            @if($errors->any())
                                <div style="background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.15); border-radius: 10px; padding: 14px 18px; margin-bottom: 20px;">
                                    <ul style="font-size: 14px; color: #dc2626; margin: 0; padding-left: 18px;">
                                        @foreach($errors->all() as $err)
                                            <li style="margin-bottom: 4px;">{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <button type="submit"
                                    style="width: 100%; padding: 13px 0; background-color: #4f46e5; color: #ffffff; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; letter-spacing: 0.01em;"
                                    onmouseover="this.style.backgroundColor='#4338ca'" onmouseout="this.style.backgroundColor='#4f46e5'">
                                Accept Invitation
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </section>
</x-frontend-layout.app>
