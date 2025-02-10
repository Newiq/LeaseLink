<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $rentals = Property::where('user_id', auth()->id())
                          ->with('images')
                          ->latest()
                          ->get();

        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        return view('rentals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'sqft' => 'required|integer|min:0',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_available'] = true;

        $property = Property::create($validated);

        return redirect()->route('rentals.show', $property)
                        ->with('success', 'Property listed successfully!');
    }

    public function show(Property $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            abort(403);
        }

        $rental->load(['owner', 'images']);
        return view('rentals.show', compact('rental'));
    }
}
