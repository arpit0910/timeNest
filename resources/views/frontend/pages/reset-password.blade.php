<x-frontend-layout.app metaTitle="Reset Password — TimeNest" metaDescription="Reset your TimeNest password.">
    <section style="padding: 120px 0 80px; min-height: 60vh;">
        <div style="max-width: 520px; margin: 0 auto; padding: 0 24px;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 48px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <div style="text-align: center; margin-bottom: 32px;">
                    <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0 0 8px;">Reset your password</h1>
                    <p style="font-size: 15px; color: #64748b; margin: 0;">Enter a new password for your account.</p>
                </div>

                <div id="alert-container" style="display: none; margin-bottom: 24px; padding: 12px; border-radius: 8px; font-size: 14px; line-height: 1.5;"></div>

                <form id="reset-password-form" onsubmit="handleResetPassword(event)">
                    <input type="hidden" id="email" name="email" value="{{ $email }}">
                    <input type="hidden" id="token" name="token" value="{{ $token }}">
                    
                    <div style="margin-bottom: 20px;">
                        <label for="password" style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 8px;">New Password</label>
                        <input type="password" id="password" name="password" required minlength="8"
                               style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; color: #0f172a; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#cbd5e1'">
                    </div>
                    
                    <div style="margin-bottom: 32px;">
                        <label for="password_confirmation" style="display: block; font-size: 14px; font-weight: 500; color: #334155; margin-bottom: 8px;">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8"
                               style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; color: #0f172a; box-sizing: border-box; outline: none;"
                               onfocus="this.style.borderColor='#4f46e5'" onblur="this.style.borderColor='#cbd5e1'">
                    </div>
                    
                    <button type="submit" id="submit-btn"
                            style="width: 100%; padding: 12px; background-color: #4f46e5; color: #ffffff; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: background-color 0.2s;"
                            onmouseover="this.style.backgroundColor='#4338ca'" onmouseout="this.style.backgroundColor='#4f46e5'">
                        Reset Password
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        async function handleResetPassword(e) {
            e.preventDefault();
            
            const btn = document.getElementById('submit-btn');
            const alertContainer = document.getElementById('alert-container');
            
            const email = document.getElementById('email').value;
            const token = document.getElementById('token').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;
            
            if (password !== password_confirmation) {
                showAlert('Passwords do not match.', 'error');
                return;
            }
            
            btn.disabled = true;
            btn.style.opacity = '0.7';
            btn.innerText = 'Resetting...';
            
            try {
                const response = await fetch('/api/v1/auth/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email, token, password, password_confirmation })
                });
                
                const data = await response.json();
                
                if (response.ok && data.success) {
                    showAlert(data.message, 'success');
                    document.getElementById('reset-password-form').reset();
                    btn.style.display = 'none';
                    setTimeout(() => {
                        window.location.href = '/'; // Or redirect to login page
                    }, 3000);
                } else {
                    showAlert(data.message || 'An error occurred. Please try again.', 'error');
                    btn.disabled = false;
                    btn.style.opacity = '1';
                    btn.innerText = 'Reset Password';
                }
            } catch (error) {
                showAlert('Network error. Please try again.', 'error');
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.innerText = 'Reset Password';
            }
        }
        
        function showAlert(message, type) {
            const container = document.getElementById('alert-container');
            container.style.display = 'block';
            container.innerText = message;
            
            if (type === 'error') {
                container.style.backgroundColor = 'rgba(239,68,68,0.1)';
                container.style.color = '#b91c1c';
                container.style.border = '1px solid rgba(239,68,68,0.2)';
            } else {
                container.style.backgroundColor = 'rgba(16,185,129,0.1)';
                container.style.color = '#047857';
                container.style.border = '1px solid rgba(16,185,129,0.2)';
            }
        }
    </script>
</x-frontend-layout.app>
