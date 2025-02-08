<nav class="bg-lease-light/80 backdrop-blur-sm fixed w-full z-10">
    <div class="container mx-auto px-4">
        <div class="w-full flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="text-lease-dark text-xl font-bold hover:text-lease flex items-center gap-2">
                <span class="text-2xl">🏘️</span>
                <span class="hidden sm:inline">LeaseLink</span>
            </a>

            <!-- Navigation Links -->
            <div class="flex items-center gap-6">
                <a href="{{ url('/properties') }}" 
                   class="text-lease-dark hover:text-lease transition-colors">
                    Properties
                </a>
                
                <a href="{{ url('/rentals') }}" 
                   class="text-lease-dark hover:text-lease transition-colors">
                    My Rentals
                </a>

                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center gap-2 text-lease-dark hover:text-lease transition-colors">
                            <span class="text-sm font-medium">Welcome, {{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                            
                            <a href="{{ url('/profile') }}" 
                               class="block px-4 py-2 text-sm text-lease-dark hover:bg-lease-light transition-colors">
                                Profile
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-lease-dark hover:bg-lease-light transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <button onclick="openLoginModal()"
                            class="bg-lease text-white px-4 py-2 rounded-full hover:bg-lease-dark transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>Login</span>
                    </button>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button class="text-lease-dark hover:text-lease transition-colors"
                        @click="mobileMenuOpen = !mobileMenuOpen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ url('/properties') }}" 
                   class="block px-3 py-2 rounded-md text-lease-dark hover:bg-lease-light transition-colors">
                    Properties
                </a>
                <a href="{{ url('/rentals') }}" 
                   class="block px-3 py-2 rounded-md text-lease-dark hover:bg-lease-light transition-colors">
                    My Rentals
                </a>
                @auth
                    <div class="px-3 py-2 text-lease-dark">
                        Welcome, {{ Auth::user()->name }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="block w-full text-left px-3 py-2 rounded-md text-lease-dark hover:bg-lease-light transition-colors">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>