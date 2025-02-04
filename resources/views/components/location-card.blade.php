@props(['city', 'province', 'imageUrl', 'propertyCount', 'averagePrice'])

<a href="{{ url('/properties?city=' . strtolower($city)) }}" 
   class="group relative block overflow-hidden rounded-lg bg-white shadow-md transition-transform hover:scale-105">
    <div class="relative h-48 overflow-hidden">
        <img src="{{ asset($imageUrl) }}"
             alt="{{ $city }}, {{ $province }}"
             class="h-full w-full object-cover transition-transform group-hover:scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
        <h3 class="text-xl font-bold">
            {{ $city }}, {{ $province }}
        </h3>
        <div class="mt-2 flex items-center justify-between text-sm">
            <span>{{ number_format($propertyCount) }} properties</span>
            <span>Avg ${{ number_format($averagePrice) }}/mo</span>
        </div>
    </div>
</a> 