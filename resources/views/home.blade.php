@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Hero Section -->
    <div class="min-h-screen relative flex items-center" style="background-image: url('{{ asset('images/hero_house.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-1 w-full px-4 sm:px-6 pt-16">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                    Find Your Perfect Home
                    <span class="block text-lease-light">With LeaseLink</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-200 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Connecting tenants and landlords seamlessly. Browse properties, connect with landlords, and find your next home.
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    <div class="rounded-md shadow">
                        <a href="{{ url('/properties') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-lease hover:bg-lease-dark md:py-4 md:text-lg md:px-10">
                            Browse Properties
                        </a>
                    </div>
                    <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                        <button onclick="openLoginModal()" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-lease-dark bg-lease-light hover:bg-white md:py-4 md:text-lg md:px-10">
                            Sign In
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Section -->
    <div class="py-12 bg-lease-peach rounded-lg mt-20 relative z-10 mx-4 my-10">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Features</h2>
            <div class="grid grid-cols-1 gap-y-12 lg:grid-cols-3 lg:gap-x-8">
                <!-- Feature 1 -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-lease-dark text-white mx-auto">
                        🔍
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-lease-dark">Easy Search</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Find properties that match your needs with our advanced search filters
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-lease-dark text-white mx-auto">
                        📱
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-lease-dark">Direct Contact</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Connect directly with landlords through our platform
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-lease-dark text-white mx-auto">
                        📋
                    </div>
                    <h3 class="mt-6 text-lg font-medium text-lease-dark">Easy Application</h3>
                    <p class="mt-2 text-base text-gray-500">
                        Simple and straightforward rental application process
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection