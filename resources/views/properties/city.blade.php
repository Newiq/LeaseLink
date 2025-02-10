@extends('layouts.app')

@section('title', $city . ' Properties')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Properties in {{ $city }}</h1>
        <a href="{{ route('properties.index') }}" class="text-lease hover:text-lease-dark">
            &larr; Back to Cities
        </a>
    </div>

    @if($properties->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600">No properties available in {{ $city }} at the moment.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($properties as $property)
            <a href="{{ route('properties.show', $property) }}" 
               class="block transform hover:scale-105 transition duration-300">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="relative h-48">
                        @if($property->images && $property->images->isNotEmpty())
                            <img src="{{ asset($property->images->where('is_primary', true)->first()->image_url) }}" 
                                 alt="{{ $property->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/properties/default_property.jpg') }}" 
                                 alt="{{ $property->title }}"
                                 class="w-full h-full object-cover">
                        @endif
                        <x-favorite-button :property="$property" />
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-lease-dark mb-2">
                            {{ $property->title }}
                        </h3>
                        <p class="text-gray-600 mb-2">
                            {{ $property->bedrooms }} bed · {{ $property->bathrooms }} bath · {{ $property->sqft }} sqft
                        </p>
                        <p class="text-lease font-bold">
                            ${{ number_format($property->price) }}/month
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>
@endsection 