@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">My Favorite Properties</h1>

    @if($favorites->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600">You haven't added any properties to your favorites yet.</p>
            <a href="{{ route('properties.index') }}" class="text-lease hover:text-lease-dark mt-4 inline-block">
                Browse Properties
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favorites as $property)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <a href="{{ route('properties.show', $property) }}" class="block">
                    <div class="relative h-48">
                        @php
                            $imageUrl = asset('images/properties/default_property.jpg');
                            if ($property->images && $property->images instanceof \Illuminate\Database\Eloquent\Collection) {
                                $primaryImage = $property->images->first();
                                if ($primaryImage) {
                                    $imageUrl = asset($primaryImage->image_url);
                                }
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" 
                             alt="{{ $property->title }}"
                             class="w-full h-full object-cover">
                    </div>
                </a>
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-lease-dark">{{ $property->title }}</h3>
                            <p class="text-gray-600">{{ $property->address }}, {{ $property->city }}</p>
                            <p class="text-lease font-bold mt-2">${{ number_format($property->price) }}/month</p>
                        </div>
                        <form action="{{ route('favorites.remove', $property) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection 