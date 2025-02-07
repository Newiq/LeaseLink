<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Property;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $favorites = auth()->user()->favorites()->with('property')->get();
        return view('favorites.index', compact('favorites'));
    }

    public function store(Property $property)
    {
        auth()->user()->favorites()->create([
            'property_id' => $property->id
        ]);

        return back()->with('success', 'Property added to favorites');
    }

    public function destroy(Property $property)
    {
        auth()->user()->favorites()
            ->where('property_id', $property->id)
            ->delete();

        return back()->with('success', 'Property removed from favorites');
    }
} 