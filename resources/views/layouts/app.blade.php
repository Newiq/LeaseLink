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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
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