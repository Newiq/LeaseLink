@extends('layouts.app')

@section('title', 'Edit Property')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Edit Property</h1>
            <a href="{{ route('rentals.show', $rental) }}" 
               class="text-lease hover:text-lease-dark flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Property
            </a>
        </div>

        <form action="{{ route('rentals.update', $rental) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Property Title</label>
                <input type="text" name="title" id="title" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                       value="{{ old('title', $rental->title) }}" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                          required>{{ old('description', $rental->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" name="city" id="city" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                           value="{{ old('city', $rental->city) }}" required>
                    @error('city')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                           value="{{ old('address', $rental->address) }}" required>
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
                           value="{{ old('price', $rental->price) }}" required min="0" step="0.01">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sqft" class="block text-sm font-medium text-gray-700">Square Feet</label>
                    <input type="number" name="sqft" id="sqft" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                           value="{{ old('sqft', $rental->sqft) }}" required min="0">
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
                           value="{{ old('bedrooms', $rental->bedrooms) }}" required min="0">
                    @error('bedrooms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms</label>
                    <input type="number" name="bathrooms" id="bathrooms" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-lease focus:ring-lease"
                           value="{{ old('bathrooms', $rental->bathrooms) }}" required min="0">
                    @error('bathrooms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 现有图片 -->
            @if($rental->images && $rental->images->isNotEmpty())
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-3">Current Images</h3>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($rental->images as $image)
                    <div class="relative group">
                        <img src="{{ asset($image->image_url) }}" 
                             alt="Property image" 
                             class="w-full aspect-square object-cover rounded-lg">
                        @if(!$image->is_primary)
                        <button type="button"
                                onclick="deleteImage({{ $image->id }})"
                                class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        @else
                        <div class="absolute top-2 right-2 bg-lease text-white px-2 py-1 rounded text-sm">
                            Primary
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- 添加新图片 -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Add More Images
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-lease hover:text-lease-dark">
                                <span>Upload images</span>
                                <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB each</p>
                    </div>
                </div>
                <div id="image-preview" class="grid grid-cols-3 gap-4 mt-4"></div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('rentals.show', $rental) }}" 
                   class="px-6 py-2 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-lease text-white px-6 py-2 rounded-full hover:bg-lease-dark transition-colors">
                    Update Property
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// 图片预览功能
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    
    [...e.target.files].forEach(file => {
        if (file.size > 10 * 1024 * 1024) {
            alert(`File ${file.name} is too large. Maximum size is 10MB`);
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative aspect-square';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover rounded-lg">
            `;
            preview.appendChild(div);
        }
        reader.readAsDataURL(file);
    });
});

// 删除图片功能
function deleteImage(imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        fetch(`/rentals/{{ $rental->id }}/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Failed to delete image. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete image. Please try again.');
        });
    }
}
</script>
@endsection 