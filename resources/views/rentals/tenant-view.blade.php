@extends('layouts.app')

@section('title', 'My Rentals')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-8 text-center">
        <h2 class="text-2xl font-semibold mb-4">Looking to List a Property?</h2>
        <p class="text-gray-600 mb-6">
            This feature is only available for landlords. If you're interested in listing properties,
            please create a landlord account.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('properties.index') }}" 
               class="bg-lease text-white px-6 py-3 rounded-full hover:bg-lease-dark transition-colors">
                Browse Properties
            </a>
            <button onclick="openLoginModal()" 
                    class="border border-lease text-lease px-6 py-3 rounded-full hover:bg-lease-light transition-colors">
                Switch to Landlord Account
            </button>
        </div>
    </div>
</div>
@endsection 