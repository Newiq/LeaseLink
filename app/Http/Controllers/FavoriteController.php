<?php

namespace App\Http\Controllers;

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
        $favorites = auth()->user()->favoriteProperties()->with('images')->get();
        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request, Property $property)
    {
        $user = auth()->user();
        $isFavorited = $user->favoriteProperties()->toggle($property->id);
        
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'isFavorited' => count($isFavorited['attached']) > 0
            ]);
        }

        return back()->with('success', 
            count($isFavorited['attached']) > 0 
                ? 'Property added to favorites.' 
                : 'Property removed from favorites.'
        );
    }

    public function remove(Property $property)
    {
        auth()->user()->favoriteProperties()->detach($property->id);
        return back()->with('success', 'Property removed from favorites.');
    }
} 