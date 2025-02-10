@extends('layouts.app')

@section('title', 'Cities')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Available Cities</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($cities as $cityData)
        <a href="{{ route('properties.city', ['city' => $cityData['city']]) }}" 
           class="block transform hover:scale-105 transition duration-300">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative h-48">
                    <img src="{{ asset($cityData['image']) }}" 
                         alt="{{ $cityData['city'] }}" 
                         class="w-full h-full object-cover"
                         onerror="this.src='{{ asset('images/properties/default_city.jpg') }}'"
                    >
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                        <h2 class="text-white text-xl font-bold">{{ $cityData['city'] }}</h2>
                        <p class="text-white text-sm">{{ $cityData['description'] }}</p>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection