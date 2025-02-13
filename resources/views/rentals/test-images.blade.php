@extends('layouts.app')

@section('title', 'Test Images')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Image Test Page</h1>

    @foreach($rental->images as $image)
    <div class="mb-8 p-4 bg-white rounded-lg shadow">
        <h2 class="text-lg font-semibold mb-2">Image ID: {{ $image->id }}</h2>
        <div class="space-y-2 mb-4">
            <p><strong>Image URL:</strong> {{ $image->image_url }}</p>
            <p><strong>Full Path:</strong> {{ public_path($image->image_url) }}</p>
            <p><strong>File Exists:</strong> {{ file_exists(public_path($image->image_url)) ? 'Yes' : 'No' }}</p>
            <p><strong>Is Primary:</strong> {{ $image->is_primary ? 'Yes' : 'No' }}</p>
            <p><strong>Display Order:</strong> {{ $image->display_order }}</p>
        </div>
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="font-medium mb-2">Direct URL:</h3>
                <img src="{{ $image->image_url }}" 
                     alt="Direct URL"
                     class="w-full h-48 object-cover rounded">
            </div>
            
            <div>
                <h3 class="font-medium mb-2">Using asset():</h3>
                <img src="{{ asset($image->image_url) }}" 
                     alt="Using asset()"
                     class="w-full h-48 object-cover rounded">
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection 