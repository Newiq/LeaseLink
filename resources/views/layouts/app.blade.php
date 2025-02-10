<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <div id="app" class="flex flex-col min-h-screen">
        @include('layouts.navigation')
        
        <main class="flex-grow pt-16">
            @yield('content')
        </main>

        <footer class="mt-auto">
            @include('layouts.footer')
        </footer>
    </div>

    @include('components.login-modal')
    @include('components.ai-chat-bubble')

    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

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
            error.classList.add('hidden');

            try {
                const baseUrl = window.location.origin;  // 使用当前域名
                
                // 首先获取 CSRF cookie
                await fetch(`${baseUrl}/sanctum/csrf-cookie`, {
                    method: 'GET',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                // 确保 cookie 已经设置
                await new Promise(resolve => setTimeout(resolve, 100));

                // 从 meta 标签获取 CSRF token
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await fetch(`${baseUrl}/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        email: document.getElementById('email').value,
                        password: document.getElementById('password').value
                    })
                });

                if (!response.ok) {
                    const data = await response.json();
                    throw new Error(data.message || 'Login failed');
                }

                const data = await response.json();
                
                // 登录成功后刷新页面
                window.location.href = data.redirect || '/';
                
            } catch (err) {
                error.textContent = err.message;
                error.classList.remove('hidden');
                console.error('Login error:', err);
            } finally {
                button.textContent = 'Sign In';
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
            const button = document.getElementById('registerButton');
            const error = document.getElementById('registerError');
            
            if (!validatePassword(document.getElementById('register-password').value)) {
                error.textContent = 'Please ensure your password meets all requirements.';
                error.classList.remove('hidden');
                return;
            }

            button.textContent = 'Registering...';
            button.disabled = true;

            try {
                const baseUrl = 'http://127.0.0.1:8000';
                
                await fetch(`${baseUrl}/sanctum/csrf-cookie`, {
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                await new Promise(resolve => setTimeout(resolve, 100));

                const xsrfToken = decodeURIComponent(getCookie('XSRF-TOKEN'));

                const response = await fetch(`${baseUrl}/register`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        name: document.getElementById('register-name').value,
                        email: document.getElementById('register-email').value,
                        password: document.getElementById('register-password').value,
                        password_confirmation: document.getElementById('register-password').value,
                        role: document.getElementById('register-role').value
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || Object.values(data.errors || {}).flat().join(' '));
                }

                document.getElementById('registerForm').reset();
                document.getElementById('register-password').classList.remove('border-green-500');
                document.querySelectorAll('#registerForm .flex.items-center span').forEach(span => {
                    span.innerHTML = '';
                });
                closeLoginModal();

                window.location.reload();
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