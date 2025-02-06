@extends('layouts.app')

@section('title', "Properties in $city")

@section('content')
<div class="container mx-auto px-4 pt-20">
    <h1 class="text-3xl font-bold text-lease-dark mb-8">Properties in {{ $city }}</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-5">
        @foreach($properties as $property)
            <x-property-card 
                :id="$property->id"
                :title="$property->title"
                :price="$property->price"
                :beds="$property->bedrooms"
                :baths="$property->bathrooms"
                :sqft="$property->sqft"
                :imageUrl="$property->primaryImage ? $property->primaryImage->image_url : 'images/placeholder.jpg'"
                :isFavorite="false"
            />
        @endforeach
    </div>
</div>
@endsection 