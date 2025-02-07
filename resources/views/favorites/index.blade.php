@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<div class="container">
    <h2>My Favorites</h2>
    <div class="row">
        @foreach($favorites as $favorite)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($favorite->property->image_url)
                        <img src="{{ $favorite->property->image_url }}" class="card-img-top" alt="Property Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $favorite->property->title }}</h5>
                        <p class="card-text">{{ $favorite->property->description }}</p>
                        <p class="card-text">
                            <strong>Price:</strong> ${{ number_format($favorite->property->price) }}
                        </p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('properties.show', $favorite->property) }}" class="btn btn-primary">View Details</a>
                            <form action="{{ route('favorites.destroy', $favorite->property) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection 