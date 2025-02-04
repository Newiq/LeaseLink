@extends('layouts.app')

@section('title', 'Properties')

@section('content')
<div class="container mx-auto px-4 pt-20">
    <h1 class="text-2xl font-bold text-lease-dark mb-8">Available Properties</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($properties as $property)
            <!-- Property Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ asset('storage/' . ($property['images'][0] ?? 'properties/default.jpg')) }}" 
                     alt="{{ $property['title'] }}" 
                     class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-lease-dark">{{ $property['title'] }}</h3>
                    <p class="text-gray-600">${{ number_format($property['price']) }}/month</p>
                    <p class="text-sm text-gray-500 mt-2">
                        {{ $property['beds'] }} beds • {{ $property['baths'] }} baths • {{ $property['sqft'] }} sqft
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- 移除分页，因为我们现在使用静态数组 -->
</div>
@endsection