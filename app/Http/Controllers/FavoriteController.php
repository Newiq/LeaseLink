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
        try {
            $favorites = auth()->user()
                ->favoriteProperties()
                ->with(['images' => function($query) {
                    $query->orderBy('is_primary', 'desc')
                          ->orderBy('id', 'asc');
                }])
                ->get();

            return view('favorites.index', compact('favorites'));
        } catch (\Exception $e) {
            \Log::error('Error in favorites index: ' . $e->getMessage());
            return back()->with('error', 'Unable to load favorites.');
        }
    }

    public function toggle(Request $request, Property $property)
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                return response()->json([
                    'error' => 'Unauthenticated',
                    'should_login' => true
                ], 401);
            }

            $isFavorited = $user->favoriteProperties()->toggle($property->id);
            
            return response()->json([
                'success' => true,
                'isFavorited' => count($isFavorited['attached']) > 0
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in favorite toggle: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to update favorite status'
            ], 500);
        }
    }

    public function remove(Property $property)
    {
        auth()->user()->favoriteProperties()->detach($property->id);
        return back()->with('success', 'Property removed from favorites.');
    }
} 