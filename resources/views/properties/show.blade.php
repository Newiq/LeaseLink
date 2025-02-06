@extends('layouts.app')

@section('title', $property->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="relative h-96">
            <img src="{{ asset($property->primaryImage?->url ?? 'images/placeholder.jpg') }}" 
                 alt="{{ $property->title }}" 
                 class="w-full h-full object-cover">
        </div>
        
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $property->title }}</h1>
                    <p class="text-gray-600">{{ $property->address }}</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-lease-primary">¥{{ number_format($property->price) }}/month</p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="text-center p-3 bg-gray-50 rounded">
                    <p class="text-sm text-gray-600">Area</p>
                    <p class="font-semibold">{{ $property->area }}㎡</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded">
                    <p class="text-sm text-gray-600">Layout</p>
                    <p class="font-semibold">{{ $property->layout }}</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded">
                    <p class="text-sm text-gray-600">Floor</p>
                    <p class="font-semibold">{{ $property->floor }}</p>
                </div>
                <div class="text-center p-3 bg-gray-50 rounded">
                    <p class="text-sm text-gray-600">Orientation</p>
                    <p class="font-semibold">{{ $property->orientation }}</p>
                </div>
            </div>

            <div class="border-t pt-6">
                <h2 class="text-xl font-semibold mb-4">Description</h2>
                <p class="text-gray-600 whitespace-pre-line">{{ $property->description }}</p>
            </div>

            <div class="border-t pt-6 mt-6">
                <h2 class="text-xl font-semibold mb-4">Amenities</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach(explode(',', $property->amenities) as $amenity)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-lease-primary mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>{{ trim($amenity) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8">
                <a href="{{ route('rentals.create', ['property_id' => $property->id]) }}" 
                   class="block w-full text-center bg-lease-primary text-white py-3 px-4 rounded-lg hover:bg-lease-primary-dark transition duration-300">
                    Apply for Rent
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 