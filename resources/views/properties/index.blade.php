@extends('layouts.app')

@section('title', 'Cities')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <form action="{{ route('properties.index') }}" method="GET" class="max-w-2xl mx-auto">
            <div class="relative">
                <input type="text" 
                       name="search" 
                       placeholder="Search properties by title..." 
                       class="w-full px-4 py-3 rounded-full border-gray-300 shadow-sm focus:border-lease focus:ring-lease pr-12"
                       value="{{ request('search') }}">
                <button type="submit" 
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-lease text-white p-2 rounded-full hover:bg-lease-dark transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <h1 class="text-2xl font-bold mb-6">Available Cities</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($cities as $cityData)
        <a href="{{ route('properties.city', ['city' => $cityData['city']]) }}" 
           class="block transform hover:scale-105 transition duration-300">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative h-48">
                    <img src="{{ asset('images/cities/' . strtolower($cityData['city']) . '.jpg') }}" 
                         alt="{{ $cityData['city'] }}" 
                         class="w-full h-full object-cover">
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