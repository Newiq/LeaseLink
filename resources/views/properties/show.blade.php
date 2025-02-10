@extends('layouts.app')

@section('title', $property->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- 返回按钮 -->
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="text-lease hover:text-lease-dark flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Properties
        </a>
    </div>

    <!-- 主要内容 -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- 图片区域 -->
        <div class="relative h-96">
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

        <!-- 属性信息 -->
        <div class="p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-lease-dark">{{ $property->title }}</h1>
                    <p class="text-gray-600">{{ $property->address }}, {{ $property->city }}</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-lease">${{ number_format($property->price) }}/month</p>
                </div>
            </div>

            <!-- 主要特征 -->
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-600">Bedrooms</p>
                    <p class="text-xl font-semibold text-lease-dark">{{ $property->bedrooms }}</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-600">Bathrooms</p>
                    <p class="text-xl font-semibold text-lease-dark">{{ $property->bathrooms }}</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-gray-600">Area</p>
                    <p class="text-xl font-semibold text-lease-dark">{{ $property->sqft }} sqft</p>
                </div>
            </div>

            <!-- 描述 -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Description</h2>
                <p class="text-gray-600">{{ $property->description }}</p>
            </div>

            <!-- 联系房东 -->
            <div class="border-t pt-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Contact Landlord</h3>
                        <p class="text-gray-600">{{ $property->owner->name }}</p>
                    </div>
                    <button class="bg-lease text-white px-6 py-2 rounded-full hover:bg-lease-dark transition-colors">
                        Send Message
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 其他图片 -->
    @if($property->images && $property->images->count() > 1)
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-4">More Photos</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($property->images->where('is_primary', false) as $image)
            <div class="relative h-48">
                <img src="{{ asset($image->image_url) }}" 
                     alt="{{ $property->title }}"
                     class="w-full h-full object-cover rounded-lg">
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection 