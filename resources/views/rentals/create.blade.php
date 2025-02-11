@extends('layouts.app')

@section('title', 'List New Property')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold mb-6">List Your Property</h1>

        <form action="{{ route('rentals.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
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

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Property Images (Select up to 10 images)
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-lease hover:text-lease-dark">
                                <span>Upload images</span>
                                <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*" required>
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG, GIF up to 10MB each
                        </p>
                    </div>
                </div>
                <div id="image-preview" class="grid grid-cols-3 gap-4 mt-4"></div>
                <div id="selected-files" class="mt-2 text-sm text-gray-500"></div>
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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

<script>
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    const selectedFiles = document.getElementById('selected-files');
    preview.innerHTML = '';
    
    if (e.target.files.length > 10) {
        alert('You can only upload up to 10 images');
        e.target.value = '';
        selectedFiles.textContent = '';
        return;
    }

    selectedFiles.textContent = `Selected ${e.target.files.length} file${e.target.files.length === 1 ? '' : 's'}`;
    
    [...e.target.files].forEach((file, index) => {
        if (file.size > 10 * 1024 * 1024) {
            alert(`File ${file.name} is too large. Maximum size is 10MB`);
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative aspect-square group';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover rounded-lg">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300">
                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        ${index === 0 ? '<span class="bg-lease text-white px-2 py-1 rounded text-sm">Primary</span>' : ''}
                    </div>
                </div>
            `;
            preview.appendChild(div);
        }
        reader.readAsDataURL(file);
    });
});

// 添加拖放支持
const dropZone = document.querySelector('.border-dashed');

function updateDropZoneState(isDragging) {
    if (isDragging) {
        dropZone.classList.add('border-lease', 'bg-lease-light/10');
    } else {
        dropZone.classList.remove('border-lease', 'bg-lease-light/10');
    }
}

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults (e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => updateDropZoneState(true), false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => updateDropZoneState(false), false);
});

dropZone.addEventListener('drop', function(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    const fileInput = document.getElementById('images');
    
    // 创建新的 FileList
    const dataTransfer = new DataTransfer();
    
    // 添加拖放的文件
    [...files].forEach(file => {
        dataTransfer.items.add(file);
    });
    
    // 更新文件输入的文件列表
    fileInput.files = dataTransfer.files;
    fileInput.dispatchEvent(new Event('change'));
});

// 添加表单提交验证
document.querySelector('form').addEventListener('submit', function(e) {
    const fileInput = document.getElementById('images');
    if (fileInput.files.length === 0) {
        e.preventDefault();
        alert('Please select at least one image');
        return false;
    }
    if (fileInput.files.length > 10) {
        e.preventDefault();
        alert('You can only upload up to 10 images');
        return false;
    }
    return true;
});
</script>
@endsection 