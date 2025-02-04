<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-8 max-w-md w-full m-4 relative animate-fade-in">
        <!-- Close button -->
        <button
            onclick="closeLoginModal()"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
        >
            ✕
        </button>

        <h2 class="text-2xl font-bold text-lease-dark mb-6 text-center">
            Sign in to LeaseLink
        </h2>

        <form id="loginForm" class="space-y-4">
            @csrf
            <div id="loginError" class="bg-red-50 text-red-700 p-3 rounded-md text-sm hidden"></div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-lease focus:border-lease"
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-lease focus:border-lease"
                >
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input
                        id="remember-me"
                        name="remember-me"
                        type="checkbox"
                        class="h-4 w-4 text-lease focus:ring-lease border-gray-300 rounded"
                    >
                    <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>
                <a href="#" class="text-sm text-lease hover:text-lease-dark">
                    Forgot password?
                </a>
            </div>

            <button
                type="submit"
                id="loginButton"
                class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-lease hover:bg-lease-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lease"
            >
                Sign in
            </button>
        </form>
    </div>
</div> 