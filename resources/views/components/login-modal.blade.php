<div id="loginModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Tabs -->
            <div class="flex border-b">
                <button onclick="switchAuthTab('login')" id="loginTab" 
                    class="px-4 py-2 border-b-2 border-lease text-lease">Sign In</button>
                <button onclick="switchAuthTab('register')" id="registerTab"
                    class="px-4 py-2 border-b-2 border-transparent text-gray-500">Register</button>
            </div>

            <!-- Login Form -->
            <form id="loginForm" class="mt-4" onsubmit="event.preventDefault();">
                @csrf
                <div id="loginError" class="hidden text-red-500 text-sm mb-4"></div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="email" type="email" required>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" 
                           id="password" type="password" required>
                </div>
                <div class="flex items-center justify-between">
                    <button id="loginButton" class="bg-lease hover:bg-lease-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                            type="submit">
                        Sign In
                    </button>
                    <button type="button" onclick="closeLoginModal()" 
                            class="text-lease hover:text-lease-dark">
                        Cancel
                    </button>
                </div>
            </form>

            <!-- Register Form -->
            <form id="registerForm" class="hidden mt-4 onsubmit="event.preventDefault();">
                <div id="registerError" class="hidden text-red-500 text-sm mb-4"></div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="register-name">
                        Name
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="register-name" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="register-email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="register-email" type="email" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="register-password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline transition-colors" 
                           id="register-password" 
                           type="password" 
                           required
                           oninput="validatePassword(this.value)">
                    <div class="mt-2 text-sm space-y-1">
                        <div id="length-check" class="flex items-center">
                            <span class="w-4 h-4 mr-2 inline-block"></span>
                            At least 8 characters
                        </div>
                        <div id="case-check" class="flex items-center">
                            <span class="w-4 h-4 mr-2 inline-block"></span>
                            Uppercase and lowercase letters
                        </div>
                        <div id="number-check" class="flex items-center">
                            <span class="w-4 h-4 mr-2 inline-block"></span>
                            At least one number
                        </div>
                        <div id="symbol-check" class="flex items-center">
                            <span class="w-4 h-4 mr-2 inline-block"></span>
                            At least one special character
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="register-role">
                        I am a:
                    </label>
                    <select id="register-role" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="tenant">Tenant</option>
                        <option value="landlord">Landlord</option>
                        <option value="both">Both</option>
                    </select>
                </div>
                <div class="flex items-center justify-between">
                    <button id="registerButton" class="bg-lease hover:bg-lease-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                            type="submit">
                        Register
                    </button>
                    <button type="button" onclick="closeLoginModal()" 
                            class="text-lease hover:text-lease-dark">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 