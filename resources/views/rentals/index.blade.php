@extends('layouts.app')

@section('title', 'My Rentals')

@section('content')
<div class="container mx-auto px-4 pt-20">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-lease-dark">My Rentals</h1>
        <button
            class="bg-lease text-white px-4 py-2 rounded-full hover:bg-lease-dark transition-colors"
            onclick="openPostModal()"
        >
            Post a Rental
        </button>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-8">
        <nav class="-mb-px flex space-x-8">
            <button
                onclick="switchTab('favorites')"
                id="favorites-tab"
                class="py-4 px-1 border-b-2 font-medium text-sm border-lease text-lease"
            >
                Favorites
            </button>
            <button
                onclick="switchTab('my-listings')"
                id="my-listings-tab"
                class="py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
            >
                My Listings
            </button>
        </nav>
    </div>

    <!-- Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div id="favorites-content">
            @include('rentals.favorites')
        </div>
        <div id="my-listings-content" class="hidden">
            @include('rentals.my-listings')
        </div>
    </div>
</div>

<!-- Post Modal -->
<div id="postModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Post a New Rental</h3>
            <form class="mt-4 text-left" action="{{ route('rentals.store') }}" method="POST">
                @csrf
                <!-- Add your form fields here -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Title
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="title" 
                           type="text" 
                           name="title" 
                           required>
                </div>
                <!-- Add more form fields as needed -->
                <div class="flex justify-end mt-4">
                    <button type="button" onclick="closePostModal()" class="mr-2 px-4 py-2 text-gray-500 hover:text-gray-700">
                        Cancel
                    </button>
                    <button type="submit" class="bg-lease text-white px-4 py-2 rounded hover:bg-lease-dark">
                        Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function switchTab(tab) {
        // Reset all tabs
        document.getElementById('favorites-tab').classList.remove('border-lease', 'text-lease');
        document.getElementById('my-listings-tab').classList.remove('border-lease', 'text-lease');
        document.getElementById('favorites-content').classList.add('hidden');
        document.getElementById('my-listings-content').classList.add('hidden');
        
        // Activate selected tab
        document.getElementById(`${tab}-tab`).classList.add('border-lease', 'text-lease');
        document.getElementById(`${tab}-content`).classList.remove('hidden');
    }

    function openPostModal() {
        document.getElementById('postModal').classList.remove('hidden');
    }

    function closePostModal() {
        document.getElementById('postModal').classList.add('hidden');
    }
</script>
@endpush 