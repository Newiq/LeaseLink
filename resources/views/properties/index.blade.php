@extends('layouts.app')

@section('title', 'Cities')

@section('content')
<div class="container mx-auto px-4 pt-20">
    <h1 class="text-3xl font-bold text-lease-dark mb-8">Find Properties by City</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($cities as $city)
            <x-location-card 
                :city="$city['city']"
                :province="$city['province']"
                :imageUrl="$city['imageUrl']"
                :propertyCount="$city['propertyCount']"
                :averagePrice="$city['averagePrice']"
            />
        @endforeach
    </div>
</div>
@endsection