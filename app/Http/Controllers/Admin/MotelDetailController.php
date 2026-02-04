<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use App\Models\MotelDetail;
use App\Models\Motel;
use App\Models\District;

class MotelDetailController extends AdminBaseController
{
    public function index(Request $request)
    {
        $query = MotelDetail::with(['motel', 'district']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('street_address', 'like', "%{$search}%")
                  ->orWhereHas('motel', function($motelQuery) use ($search) {
                      $motelQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by district
        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }
        
        $motelDetails = $query->orderBy('created_at', 'desc')->paginate(20);
        $districts = District::orderBy('name')->get();
        
        return view('adminpages.motel-details.index', compact('motelDetails', 'districts'));
    }

    public function create()
    {
        $motels = Motel::orderBy('name')->get();
        $districts = District::orderBy('name')->get();
        
        return view('adminpages.motel-details.create', compact('motels', 'districts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'motel_id' => 'required|exists:bnb_motels,id',
            'district_id' => 'nullable|exists:districts,id',
            'street_address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'total_rooms' => 'required|integer|min:0',
            'available_rooms' => 'required|integer|min:0',
            'rate' => 'required|numeric|min:0',
        ]);

        // Handle front image upload
        if ($request->hasFile('front_image')) {
            $image = $request->file('front_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/motels'), $imageName);
            $data['front_image'] = 'images/motels/' . $imageName;
        }

        $motelDetail = MotelDetail::create($data);
        
        return redirect()->route('adminpages.motel-details.index')
                        ->with('success', 'Motel Detail created successfully.');
    }

    public function show($id)
    {
        $motelDetail = MotelDetail::with(['motel', 'district'])->findOrFail($id);
        return view('adminpages.motel-details.show', compact('motelDetail'));
    }

    public function edit($id)
    {
        $motelDetail = MotelDetail::findOrFail($id);
        $motels = Motel::orderBy('name')->get();
        $districts = District::orderBy('name')->get();
        
        return view('adminpages.motel-details.edit', compact('motelDetail', 'motels', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $motelDetail = MotelDetail::findOrFail($id);
        $data = $request->validate([
            'motel_id' => 'required|exists:bnb_motels,id',
            'district_id' => 'nullable|exists:districts,id',
            'street_address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'total_rooms' => 'required|integer|min:0',
            'available_rooms' => 'required|integer|min:0',
            'rate' => 'required|numeric|min:0',
        ]);

        // Handle front image upload
        if ($request->hasFile('front_image')) {
            // Delete old image if exists
            if ($motelDetail->front_image && file_exists(public_path($motelDetail->front_image))) {
                unlink(public_path($motelDetail->front_image));
            }
            
            $image = $request->file('front_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/motels'), $imageName);
            $data['front_image'] = 'images/motels/' . $imageName;
        }
        
        $motelDetail->update($data);
        
        return redirect()->route('adminpages.motel-details.index')
                        ->with('success', 'Motel Detail updated successfully.');
    }

    public function destroy($id)
    {
        $motelDetail = MotelDetail::findOrFail($id);
        
        // Delete front image if exists
        if ($motelDetail->front_image && file_exists(public_path($motelDetail->front_image))) {
            unlink(public_path($motelDetail->front_image));
        }
        
        $motelDetail->delete();
        
        return redirect()->route('adminpages.motel-details.index')
                        ->with('success', 'Motel Detail deleted successfully.');
    }
}
