@extends('layouts.app')

@section('title', ucfirst($city))

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Properties in {{ ucfirst($city) }}</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($properties as $property)
        <a href="{{ route('properties.show', $property) }}" class="block transform hover:scale-105 transition duration-300">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset($property->primaryImage?->url ?? 'images/placeholder.jpg') }}" 
                     alt="{{ $property->title }}" 
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-lease-dark mb-2">{{ $property->title }}</h3>
                    <p class="text-gray-600 mb-2">¥{{ number_format($property->price) }}/月</p>
                    <p class="text-sm text-gray-500">{{ $property->address }}</p>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="mr-2">{{ $property->area }}㎡</span>
                        <span>{{ $property->layout }}</span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endsection 