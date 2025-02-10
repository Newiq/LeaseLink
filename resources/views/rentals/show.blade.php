@extends('layouts.app')

@section('title', $rental->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- 返回按钮 -->
    <div class="mb-6">
        <a href="{{ route('rentals.index') }}" class="text-lease hover:text-lease-dark flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to My Rentals
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- 主图 -->
        <div class="relative h-96">
            @if($rental->images && $rental->images->isNotEmpty())
                <img src="{{ asset($rental->images->where('is_primary', true)->first()->image_url) }}" 
                     alt="{{ $rental->title }}"
                     class="w-full h-full object-cover">
            @else
                <img src="{{ asset('images/properties/default_property.jpg') }}" 
                     alt="{{ $rental->title }}"
                     class="w-full h-full object-cover">
            @endif
        </div>

        <div class="p-6">
            <!-- 基本信息 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h1 class="text-2xl font-bold text-lease-dark mb-2">{{ $rental->title }}</h1>
                    <p class="text-gray-600 mb-4">{{ $rental->address }}, {{ $rental->city }}</p>
                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Bedrooms</p>
                            <p class="text-lg font-semibold text-lease-dark">{{ $rental->bedrooms }}</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Bathrooms</p>
                            <p class="text-lg font-semibold text-lease-dark">{{ $rental->bathrooms }}</p>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Area</p>
                            <p class="text-lg font-semibold text-lease-dark">{{ $rental->sqft }} sqft</p>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-lease">${{ number_format($rental->price) }}/month</p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Owner Information</h2>
                    <div class="space-y-2">
                        <p class="text-gray-600"><span class="font-medium">Name:</span> {{ $rental->owner->name }}</p>
                        <p class="text-gray-600"><span class="font-medium">Contact:</span> {{ $rental->owner->phone ?? 'Not provided' }}</p>
                        <p class="text-gray-600"><span class="font-medium">Email:</span> {{ $rental->owner->email }}</p>
                    </div>
                </div>
            </div>

            <!-- 详细描述 -->
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Description</h2>
                <p class="text-gray-600 whitespace-pre-line">{{ $rental->description }}</p>
            </div>

            <!-- 更多图片 -->
            @if($rental->images && $rental->images->count() > 1)
            <div class="mt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">More Photos</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($rental->images->where('is_primary', false) as $image)
                    <div class="relative h-48">
                        <img src="{{ asset($image->image_url) }}" 
                             alt="{{ $rental->title }}"
                             class="w-full h-full object-cover rounded-lg">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 