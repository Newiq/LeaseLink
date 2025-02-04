<nav class="bg-lease-light/80 backdrop-blur-sm fixed w-full z-10">
    <div class="container mx-auto px-4">
        <div class="w-full flex justify-between items-center h-16">
            <a href="{{ url('/') }}" class="text-lease-dark text-xl font-bold hover:text-lease flex items-center gap-2">
                <span class="text-2xl">🏘️</span>
                <span class="hidden sm:inline">LeaseLink</span>
            </a>
            
            <div class="flex items-center gap-6">
                <a 
                    href="{{ url('/properties') }}" 
                    class="text-lease-dark hover:text-lease transition-colors"
                >
                    Properties
                </a>
                <a 
                    href="{{ url('/rentals') }}" 
                    class="text-lease-dark hover:text-lease transition-colors"
                >
                    My Rentals
                </a>

                    <button 
                    onclick="openLoginModal()"
                    class="bg-lease text-white px-4 py-2 rounded-full hover:bg-lease-dark transition-colors"
                    >
                    Login
                    </button>
            </div>
        </div>
    </div>
</nav>