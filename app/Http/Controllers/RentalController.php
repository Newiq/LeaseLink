<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $rentals = Property::where('user_id', auth()->id())
                ->with(['images' => function($query) {
                    $query->orderBy('is_primary', 'desc')
                          ->orderBy('id', 'asc');
                }])
                ->latest()
                ->get();

            return view('rentals.index', compact('rentals'));
        } catch (\Exception $e) {
            \Log::error('Error in rentals index: ' . $e->getMessage());
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

        $validated['user_id'] = auth()->id();
        $validated['is_available'] = true;

        try {
            \DB::beginTransaction();

            $property = Property::create($validated);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('images/properties', 'public');
                    
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image_url' => $path,
                        'is_primary' => $index === 0,
                        'display_order' => $index
                    ]);
                }
            }

            \DB::commit();
            return redirect()->route('rentals.show', $property)
                            ->with('success', 'Property listed successfully!');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error creating property: ' . $e->getMessage());
            return back()->withInput()
                        ->with('error', 'Failed to create property. Please try again.');
        }
    }

    public function show(Property $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            abort(403);
        }

        $rental->load(['owner', 'images']);
        return view('rentals.show', compact('rental'));
    }

    public function edit(Property $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            abort(403);
        }

        return view('rentals.edit', compact('rental'));
    }

    public function update(Request $request, Property $rental)
    {
        if ($rental->user_id !== auth()->id()) {
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
            \DB::beginTransaction();

            $rental->update($validated);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('images/properties', 'public');
                    
                    PropertyImage::create([
                        'property_id' => $rental->id,
                        'image_url' => $path,
                        'is_primary' => false,
                        'display_order' => $rental->images->count() + $index
                    ]);
                }
            }

            \DB::commit();
            return redirect()->route('rentals.show', $rental)
                            ->with('success', 'Property updated successfully!');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error updating property: ' . $e->getMessage());
            return back()->withInput()
                        ->with('error', 'Failed to update property. Please try again.');
        }
    }

    public function destroy(Property $rental)
    {
        try {
            // 检查权限
            if ($rental->user_id !== auth()->id()) {
                return back()->with('error', 'You are not authorized to delete this property.');
            }

            // 加载图片关系
            $rental->load('images');

            // 开始事务
            \DB::beginTransaction();

            // 删除相关的图片文件
            if ($rental->images) {
                foreach ($rental->images as $image) {
                    try {
                        $path = str_replace('storage/', '', $image->image_url);
                        if (Storage::disk('public')->exists($path)) {
                            Storage::disk('public')->delete($path);
                        }
                    } catch (\Exception $e) {
                        \Log::warning("Failed to delete image file: {$image->image_url}, Error: " . $e->getMessage());
                    }
                }
            }

            // 删除数据库记录
            $rental->images()->delete();
            $rental->delete();

            // 提交事务
            \DB::commit();

            return redirect()->route('rentals.index')
                            ->with('success', 'Property deleted successfully!');

        } catch (\Exception $e) {
            // 回滚事务
            \DB::rollBack();
            
            // 记录错误
            \Log::error('Error deleting property: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'Failed to delete property. Please try again.');
        }
    }

    public function deleteImage(Property $rental, PropertyImage $image)
    {
        if ($rental->user_id !== auth()->id() || $image->property_id !== $rental->id) {
            abort(403);
        }

        try {
            Storage::disk('public')->delete($image->image_url);
            $image->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Error deleting image: ' . $e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}
