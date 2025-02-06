<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div id="app">
        @include('layouts.navigation')
        
        <main>
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>

    @include('components.login-modal')
    @include('components.ai-chat-bubble')

    <script>
        function openLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
        }

        function switchAuthTab(tab) {
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');

            if (tab === 'login') {
                loginTab.classList.add('border-lease', 'text-lease');
                registerTab.classList.remove('border-lease', 'text-lease');
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
            } else {
                registerTab.classList.add('border-lease', 'text-lease');
                loginTab.classList.remove('border-lease', 'text-lease');
                registerForm.classList.remove('hidden');
                loginForm.classList.add('hidden');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const button = document.getElementById('loginButton');
            const error = document.getElementById('loginError');
            button.textContent = 'Signing in...';
            button.disabled = true;

            try {
                const response = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        email: document.getElementById('email').value,
                        password: document.getElementById('password').value
                    })
                });

                if (!response.ok) {
                    throw new Error('Invalid credentials');
                }

                const data = await response.json();
                localStorage.setItem('token', data.token);
                window.location.href = '/';
            } catch (err) {
                error.textContent = 'Invalid email or password';
                error.classList.remove('hidden');
            } finally {
                button.textContent = 'Sign in';
                button.disabled = false;
            }
        });

        function validatePassword(password) {
            const input = document.getElementById('register-password');
            const checks = {
                'length-check': password.length >= 8,
                'case-check': /(?=.*[a-z])(?=.*[A-Z])/.test(password),
                'number-check': /\d/.test(password),
                'symbol-check': /[!@#$%^&*(),.?":{}|<>]/.test(password)
            };

            let allValid = true;
            Object.entries(checks).forEach(([id, valid]) => {
                const element = document.getElementById(id);
                const icon = element.querySelector('span');
                
                if (valid) {
                    element.classList.remove('text-red-500');
                    element.classList.add('text-green-500');
                    icon.innerHTML = '✓';
                } else {
                    element.classList.remove('text-green-500');
                    element.classList.add('text-red-500');
                    icon.innerHTML = '✗';
                    allValid = false;
                }
            });

            // 更新输入框边框颜色
            if (password === '') {
                input.classList.remove('border-red-500', 'border-green-500');
            } else if (allValid) {
                input.classList.remove('border-red-500');
                input.classList.add('border-green-500');
            } else {
                input.classList.remove('border-green-500');
                input.classList.add('border-red-500');
            }

            return allValid;
        }

        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const password = document.getElementById('register-password').value;
            
            if (!validatePassword(password)) {
                const error = document.getElementById('registerError');
                error.textContent = 'Please ensure your password meets all requirements.';
                error.classList.remove('hidden');
                return;
            }

            const button = document.getElementById('registerButton');
            const error = document.getElementById('registerError');
            button.textContent = 'Registering...';
            button.disabled = true;

            try {
                const response = await fetch('/api/auth/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        name: document.getElementById('register-name').value,
                        email: document.getElementById('register-email').value,
                        password: document.getElementById('register-password').value,
                        role: document.getElementById('register-role').value
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    let errorMessage = 'Registration failed. ';
                    if (data.errors) {
                        errorMessage += Object.values(data.errors).flat().join(' ');
                    }
                    throw new Error(errorMessage);
                }

                // 注册成功后重置表单和状态
                document.getElementById('registerForm').reset();
                document.getElementById('register-password').classList.remove('border-green-500');
                document.querySelectorAll('#registerForm .flex.items-center span').forEach(span => {
                    span.innerHTML = '';
                });
                closeLoginModal();

                localStorage.setItem('token', data.token);
                window.location.href = '/';
            } catch (err) {
                error.textContent = err.message;
                error.classList.remove('hidden');
            } finally {
                button.textContent = 'Register';
                button.disabled = false;
            }
        });

        function toggleChat() {
            const bubble = document.getElementById('chatBubble');
            const isHidden = bubble.classList.contains('hidden');
            
            if (isHidden) {
                bubble.classList.remove('hidden');
                setTimeout(() => {
                    bubble.classList.add('hidden');
                }, 3000);
            } else {
                bubble.classList.add('hidden');
            }
        }
    </script>
</body>
</html>