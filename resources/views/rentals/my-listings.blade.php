@foreach($myListings as $property)
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <img src="{{ asset($property->image_url) }}" alt="{{ $property->title }}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="text-lg font-semibold text-lease-dark">{{ $property->title }}</h3>
        <p class="text-gray-600">${{ number_format($property->price) }}/month</p>
        <p class="text-sm text-gray-500">{{ $property->location }}</p>
        <div class="mt-4 flex justify-end space-x-2">
            <button class="text-lease hover:text-lease-dark">Edit</button>
            <button class="text-red-500 hover:text-red-700">Delete</button>
        </div>
    </div>
</div>
@endforeach 