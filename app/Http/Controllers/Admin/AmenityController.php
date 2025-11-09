<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Amenity;

class AmenityController extends Controller
{
    public function index(Request $request)
    {
        $query = Amenity::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('createdby', 'like', "%{$search}%");
            });
        }
        
        $amenities = $query->orderBy('name')->paginate(20);
        
        return view('adminpages.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('adminpages.amenities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/amenities'), $imageName);
            $data['icon'] = 'images/amenities/' . $imageName;
        }

        // Set createdby to authenticated user ID
        $data['createdby'] = auth()->id();

        $amenity = Amenity::create($data);
        
        return redirect()->route('adminpages.amenities.index')
                        ->with('success', 'Amenity created successfully.');
    }

    public function show($id)
    {
        $amenity = Amenity::findOrFail($id);
        return view('adminpages.amenities.show', compact('amenity'));
    }

    public function edit($id)
    {
        $amenity = Amenity::findOrFail($id);
        return view('adminpages.amenities.edit', compact('amenity'));
    }

    public function update(Request $request, $id)
    {
        $amenity = Amenity::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('icon')) {
            // Delete old image if exists
            if ($amenity->icon && file_exists(public_path($amenity->icon))) {
                unlink(public_path($amenity->icon));
            }
            
            $image = $request->file('icon');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/amenities'), $imageName);
            $data['icon'] = 'images/amenities/' . $imageName;
        }
        
        $amenity->update($data);
        
        return redirect()->route('adminpages.amenities.index')
                        ->with('success', 'Amenity updated successfully.');
    }

    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);
        
        // Delete image file if exists
        if ($amenity->icon && file_exists(public_path($amenity->icon))) {
            unlink(public_path($amenity->icon));
        }
        
        $amenity->delete();
        
        return redirect()->route('adminpages.amenities.index')
                        ->with('success', 'Amenity deleted successfully.');
    }
}
