@extends('layouts.app')

@section('title', 'Apply for Rent')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">Apply for Rent</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Property Details</h2>
            <div class="flex items-center mb-4">
                <img src="{{ asset($property->primaryImage?->url ?? 'images/placeholder.jpg') }}" 
                     alt="{{ $property->title }}" 
                     class="w-24 h-24 object-cover rounded mr-4">
                <div>
                    <h3 class="font-semibold">{{ $property->title }}</h3>
                    <p class="text-gray-600">{{ $property->address }}</p>
                    <p class="text-lease-primary font-semibold">¥{{ number_format($property->price) }}/month</p>
                </div>
            </div>
        </div>

        <form action="{{ route('rentals.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
            @csrf
            <input type="hidden" name="property_id" value="{{ $property->id }}">
            
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Move-in Date</label>
                <input type="date" name="move_in_date" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-lease-primary"
                       required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Lease Term (months)</label>
                <select name="lease_term" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-lease-primary"
                        required>
                    <option value="12">12 months</option>
                    <option value="24">24 months</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Additional Notes</label>
                <textarea name="notes" rows="4" 
                          class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-lease-primary"></textarea>
            </div>

            <button type="submit" 
                    class="w-full bg-lease-primary text-white py-3 px-4 rounded-lg hover:bg-lease-primary-dark transition duration-300">
                Submit Application
            </button>
        </form>
    </div>
</div>
@endsection 