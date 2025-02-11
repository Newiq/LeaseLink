@extends('layouts.app')

@section('title', 'My Rentals')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container mx-auto px-4 py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">My Rental Properties</h1>
        <a href="{{ route('rentals.create') }}" 
           class="bg-lease text-white px-4 py-2 rounded-full hover:bg-lease-dark transition-colors">
            List New Property
        </a>
    </div>

    @if($rentals->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h2 class="text-xl font-semibold mb-4">No Properties Listed Yet</h2>
            <p class="text-gray-600 mb-6">Start earning by listing your property on LeaseLink!</p>
            <a href="{{ route('rentals.create') }}" 
               class="bg-lease text-white px-6 py-3 rounded-full hover:bg-lease-dark transition-colors inline-block">
                List Your First Property
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($rentals as $rental)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="relative h-48">
                    @php
                        $imageUrl = asset('images/properties/default_property.jpg');
                        if ($rental->images && $rental->images->isNotEmpty()) {
                            $primaryImage = $rental->images->where('is_primary', true)->first();
                            if ($primaryImage) {
                                $imageUrl = Storage::disk('public')->url($primaryImage->image_url);
                            }
                        }
                    @endphp
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $rental->title }}"
                         class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-lease-dark">{{ $rental->title }}</h3>
                    <p class="text-gray-600">{{ $rental->address }}, {{ $rental->city }}</p>
                    <p class="text-lease font-bold mt-2">${{ number_format($rental->price) }}/month</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            {{ $rental->is_available ? 'Available' : 'Not Available' }}
                        </span>
                        <a href="{{ route('rentals.show', $rental) }}" 
                           class="text-lease hover:text-lease-dark">
                            View Details →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection 