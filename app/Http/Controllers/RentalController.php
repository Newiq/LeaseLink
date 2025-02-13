<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        if (!Storage::disk('public')->exists('images/properties/default_property.jpg')) {
            Storage::disk('public')->copy(
                'images/default_property.jpg',
                'images/properties/default_property.jpg'
            );
        }
    }

    public function index()
    {
        try {
            $rentals = Property::where('user_id', Auth::id())
                ->with(['images' => function($query) {
                    $query->orderBy('is_primary', 'desc')
                          ->orderBy('id', 'asc');
                }])
                ->latest()
                ->get();

            return view('rentals.index', compact('rentals'));
        } catch (\Exception $e) {
            Log::error('Error in rentals index: ' . $e->getMessage());
            return back()->with('error', 'Unable to load rentals.');
        }
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
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240'
        ], [
            'images.required' => 'Please upload at least one image',
            'images.min' => 'Please upload at least one image',
            'images.max' => 'You can only upload up to 10 images',
            'images.*.max' => 'Each image must not exceed 10MB'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_available'] = true;

        try {
            DB::beginTransaction();

            $property = Property::create($validated);

            if ($request->hasFile('images')) {
                $directory = public_path('images/properties');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                $maxDisplayOrder = PropertyImage::where('property_id', $property->id)
                    ->max('display_order') ?? -1;

                foreach ($request->file('images') as $index => $image) {
                    $filename = uniqid(time() . '_') . '.' . $image->getClientOriginalExtension();
                    
                    try {
                        if (!$image->move($directory, $filename)) {
                            throw new \Exception("Failed to move uploaded file");
                        }
                        
                        $path = 'images/properties/' . $filename;
                        
                        if (!file_exists(public_path($path))) {
                            throw new \Exception("File does not exist after upload: " . $path);
                        }

                        PropertyImage::create([
                            'property_id' => $property->id,
                            'image_url' => $path,
                            'is_primary' => ($index === 0), 
                            'display_order' => $maxDisplayOrder + $index + 1
                        ]);
                        
                        Log::info('Image uploaded successfully', [
                            'path' => $path,
                            'exists' => file_exists(public_path($path)),
                            'is_primary' => ($index === 0)
                        ]);
                        
                    } catch (\Exception $e) {
                        Log::error('Failed to process image:', [
                            'error' => $e->getMessage(),
                            'file' => $filename
                        ]);
                        throw $e;
                    }
                }
            }

            DB::commit();
            return redirect()->route('rentals.show', $property)
                            ->with('success', 'Property listed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating property: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->withInput()
                        ->with('error', 'Failed to create property. Please try again.');
        }
    }

    public function show(Property $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        $rental->load(['owner', 'images' => function($query) {
            $query->orderBy('is_primary', 'desc')
                  ->orderBy('display_order', 'asc');
        }]);
        
        return view('rentals.show', compact('rental'));
    }

    public function edit(Property $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        $rental->load('images');
        return view('rentals.edit', compact('rental'));
    }

    public function update(Request $request, Property $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'sqft' => 'required|integer|min:0',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        try {
            DB::beginTransaction();

            $rental->update($validated);

            if ($request->hasFile('images')) {
                $directory = public_path('images/properties');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                $maxDisplayOrder = $rental->images()
                    ->max('display_order') ?? -1;

                foreach ($request->file('images') as $index => $image) {
                    $filename = uniqid(time() . '_') . '.' . $image->getClientOriginalExtension();
                    
                    try {
                        if (!$image->move($directory, $filename)) {
                            throw new \Exception("Failed to move uploaded file");
                        }
                        
                        $path = 'images/properties/' . $filename;
                        
                        if (!file_exists(public_path($path))) {
                            throw new \Exception("File does not exist after upload: " . $path);
                        }
                        
                        PropertyImage::create([
                            'property_id' => $rental->id,
                            'image_url' => $path,
                            'is_primary' => $rental->images()->count() === 0 && $index === 0, // 只有在没有其他图片时，第一张图片才是主图
                            'display_order' => $maxDisplayOrder + $index + 1
                        ]);
                        
                        Log::info('Image uploaded successfully', [
                            'path' => $path,
                            'exists' => file_exists(public_path($path))
                        ]);
                        
                    } catch (\Exception $e) {
                        Log::error('Failed to process image:', [
                            'error' => $e->getMessage(),
                            'file' => $filename
                        ]);
                        throw $e;
                    }
                }
            }

            DB::commit();
            return redirect()->route('rentals.show', $rental)
                            ->with('success', 'Property updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating property: ' . $e->getMessage());
            return back()->withInput()
                        ->with('error', 'Failed to update property. Please try again.');
        }
    }

    public function destroy(Property $rental)
    {
        try {

            if ($rental->user_id !== Auth::id()) {
                return back()->with('error', 'You are not authorized to delete this property.');
            }


            $rental->load('images');


            DB::beginTransaction();


            if ($rental->images) {
                foreach ($rental->images as $image) {
                    try {
                        $path = str_replace('storage/', '', $image->image_url);
                        if (Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                    } catch (\Exception $e) {
                        Log::warning("Failed to delete image file: {$image->image_url}, Error: " . $e->getMessage());
                    }
                }
            }


            $rental->images()->delete();
            $rental->delete();


            DB::commit();

            return redirect()->route('rentals.index')
                            ->with('success', 'Property deleted successfully!');

        } catch (\Exception $e) {

            DB::rollBack();
            
            Log::error('Error deleting property: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'Failed to delete property. Please try again.');
        }
    }

    public function deleteImage(Property $rental, PropertyImage $image)
    {
        if ($rental->user_id !== Auth::id() || $image->property_id !== $rental->id) {
            abort(403);
        }

        try {
            Storage::disk('public')->delete($image->image_url);
            $image->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error deleting image: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}
