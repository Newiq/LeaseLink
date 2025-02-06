@extends('layouts.app')

@section('title', 'Cities')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Available Cities</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cities as $cityData)
        <a href="{{ route('properties.index', ['city' => $cityData['city']]) }}" 
           class="block transform hover:scale-105 transition duration-300">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset($cityData['imageUrl']) }}" 
                     alt="{{ $cityData['city'] }}" 
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-lease-dark mb-2">
                        {{ $cityData['city'] }}, {{ $cityData['province'] }}
                    </h3>
                    <p class="text-gray-600 mb-2">
                        {{ $cityData['propertyCount'] }} properties available
                    </p>
                    <p class="text-sm text-gray-500">
                        Average price: ¥{{ number_format($cityData['averagePrice']) }}/month
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection