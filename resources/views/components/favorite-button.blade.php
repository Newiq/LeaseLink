@props(['property'])

@auth
<div x-data="{ 
    isFavorited: {{ auth()->user()->favoriteProperties->contains($property->id) ? 'true' : 'false' }},
    async toggleFavorite() {
        try {
            const response = await fetch('{{ route('favorites.toggle', $property) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '{{ route('login') }}';
                    return;
                }
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            this.isFavorited = data.isFavorited;
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to update favorite status');
        }
    }
}">
    <button @click.prevent="toggleFavorite()" 
            class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-md hover:scale-110 transition-transform"
            :class="{ 'text-red-500': isFavorited, 'text-gray-400': !isFavorited }">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
        </svg>
    </button>
</div>
@else
<button onclick="openLoginModal()" 
        class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-md hover:scale-110 transition-transform text-gray-400">
    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
    </svg>
</button>
@endauth 