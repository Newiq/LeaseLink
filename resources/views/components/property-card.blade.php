@props(['id', 'title', 'price', 'beds', 'baths', 'sqft', 'imageUrl', 'isFavorite'])

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="relative">
        <img src="{{ asset($imageUrl) }}" 
             alt="{{ $title }}" 
             class="w-full h-48 object-cover">
        <button 
            class="absolute top-2 right-2 p-2 rounded-full bg-white/80 hover:bg-white"
            onclick="toggleFavorite('{{ $id }}')"
        >
            <svg class="w-6 h-6 {{ $isFavorite ? 'text-red-500' : 'text-gray-400' }}" 
                 fill="{{ $isFavorite ? 'currentColor' : 'none' }}" 
                 stroke="currentColor" 
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" 
                      stroke-linejoin="round" 
                      stroke-width="2" 
                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                </path>
            </svg>
        </button>
    </div>
    <div class="p-4">
        <h3 class="text-lg font-semibold text-lease-dark">{{ $title }}</h3>
        <p class="text-xl font-bold text-lease mt-1">${{ number_format($price) }}/month</p>
        <div class="flex items-center gap-4 mt-2 text-gray-600">
            <span>{{ $beds }} beds</span>
            <span>{{ $baths }} baths</span>
            <span>{{ number_format($sqft) }} sqft</span>
        </div>
    </div>
</div> 