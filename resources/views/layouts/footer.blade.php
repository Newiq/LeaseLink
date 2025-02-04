<footer class="bg-lease-light border-t border-gray-200">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo and Description -->
            <div class="col-span-1 md:col-span-2">
                <a href="/" class="flex items-center gap-2 mb-4">
                    <span class="text-2xl">🏘️</span>
                    <span class="text-xl font-bold text-lease-dark">LeaseLink</span>
                </a>
                <p class="text-gray-600 mb-4">
                    Connecting tenants and landlords seamlessly. Find your perfect home with LeaseLink.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lease-dark font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="/properties" class="text-gray-600 hover:text-lease">Browse Properties</a></li>
                    <li><a href="/rentals" class="text-gray-600 hover:text-lease">My Rentals</a></li>
                    <li><a href="/about" class="text-gray-600 hover:text-lease">About Us</a></li>
                    <li><a href="/contact" class="text-gray-600 hover:text-lease">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="text-lease-dark font-semibold mb-4">Contact Us</h3>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-center gap-2">
                        <span>📍</span>
                        <span>123 Main Street</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span>📞</span>
                        <span>(555) 123-4567</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span>✉️</span>
                        <span>support@leaselink.com</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-500">
            <p>© {{ date('Y') }} LeaseLink. All rights reserved.</p>
        </div>
    </div>
</footer> 