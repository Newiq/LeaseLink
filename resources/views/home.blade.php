@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="min-h-screen relative flex items-center" style="background-image: url('{{ asset('images/hero_house.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-1 w-full px-4 sm:px-6 pt-16">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                    Find Your Perfect Home
                    <span class="block text-lease-light">With LeaseLink</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-200 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Connecting tenants and landlords seamlessly. Browse properties, connect with landlords, and find your next home.
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <a href="{{ url('/properties') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-lease hover:bg-lease-dark md:py-4 md:text-lg md:px-10">
                            Browse Properties
                        </a>
                    </div>
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                        <button onclick="openLoginModal()" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-lease-dark bg-lease-light hover:bg-white md:py-4 md:text-lg md:px-10">
                            Sign In
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Section -->
    <div class="py-12 bg-lease-peach rounded-lg mt-20 relative z-10 mx-4 my-10">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Features</h2>
            <div class="grid grid-cols-1 gap-y-12 lg:grid-cols-3 lg:gap-x-8">
                <!-- Feature 1 -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-lease-dark text-white mx-auto">
                        🔍
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-lease-dark">Easy Search</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Find properties that match your needs with our advanced search filters
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-lease-dark text-white mx-auto">
                        📱
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-lease-dark">Direct Contact</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Connect directly with landlords through our platform
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-lease-dark text-white mx-auto">
                        ⚡
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-lease-dark">Quick Process</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Streamlined rental process from search to signing
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto px-4">
    <!-- City selection section -->
    @if(isset($cities) && $cities->count() > 0)
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">热门城市</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($cities as $city)
            <button class="city-btn p-4 text-center rounded-lg border-2 {{ ($selectedCity ?? '') == $city->id ? 'border-lease text-lease' : 'border-gray-200 hover:border-lease hover:text-lease' }}"
                    data-city-id="{{ $city->id }}">
                {{ $city->name }}
            </button>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Property list section -->
    <div id="propertyList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($properties ?? [] as $property)
        <a href="{{ route('rentals.show', $property) }}" class="block transform hover:scale-105 transition duration-300">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset($property->image_url) }}" alt="{{ $property->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-lease-dark mb-2">{{ $property->title }}</h3>
                    <p class="text-gray-600 mb-2">¥{{ number_format($property->price, 2) }}/月</p>
                    <p class="text-sm text-gray-500">{{ $property->address }}</p>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="mr-2">{{ $property->area }}㎡</span>
                        <span>{{ $property->layout }}</span>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <p class="col-span-full text-center text-gray-500">No properties found</p>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
    // 城市选择的 JavaScript 代码保持不变
    document.querySelectorAll('.city-btn').forEach(button => {
        button.addEventListener('click', async () => {
            const cityId = button.dataset.cityId;
            
            // 更新按钮样式
            document.querySelectorAll('.city-btn').forEach(btn => {
                btn.classList.remove('border-lease', 'text-lease');
                btn.classList.add('border-gray-200');
            });
            button.classList.add('border-lease', 'text-lease');
            button.classList.remove('border-gray-200');
            
            try {
                const response = await fetch(`/api/properties?city_id=${cityId}`);
                const data = await response.json();
                
                // 更新房产列表
                const propertyList = document.getElementById('propertyList');
                propertyList.innerHTML = data.map(property => `
                    <a href="/rentals/${property.id}" class="block transform hover:scale-105 transition duration-300">
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <img src="${property.image_url}" alt="${property.title}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-lease-dark mb-2">${property.title}</h3>
                                <p class="text-gray-600 mb-2">¥${Number(property.price).toLocaleString()}/月</p>
                                <p class="text-sm text-gray-500">${property.address}</p>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <span class="mr-2">${property.area}㎡</span>
                                    <span>${property.layout}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                `).join('');
                
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
</script>
@endpush
@endsection