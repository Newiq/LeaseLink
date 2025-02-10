@extends('layouts.app')

@section('title', 'List New Property')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">List Your Property</h1>

        <form action="{{ route('rentals.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Property Title</label>
                <input type="text" name="title" id="title" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                       value="{{ old('title') }}" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="city" id="city" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                           value="{{ old('city') }}" required>
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                           value="{{ old('address') }}" required>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Monthly Rent ($)</label>
                    <input type="number" name="price" id="price" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                           value="{{ old('price') }}" required min="0" step="0.01">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sqft" class="block text-sm font-medium text-gray-700">Square Feet</label>
                    <input type="number" name="sqft" id="sqft" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                           value="{{ old('sqft') }}" required min="0">
                    @error('sqft')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="bedrooms" class="block text-sm font-medium text-gray-700">Bedrooms</label>
                    <input type="number" name="bedrooms" id="bedrooms" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                           value="{{ old('bedrooms') }}" required min="0">
                    @error('bedrooms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms</label>
                    <input type="number" name="bathrooms" id="bathrooms" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                           value="{{ old('bathrooms') }}" required min="0">
                    @error('bathrooms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="bg-lease text-white px-6 py-2 rounded-full hover:bg-lease-dark transition-colors">
                    List Property
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 