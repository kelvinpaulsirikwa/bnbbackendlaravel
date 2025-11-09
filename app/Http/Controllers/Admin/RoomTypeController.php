<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = RoomType::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $roomTypes = $query->orderBy('name')->paginate(20);
        
        return view('adminpages.room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('adminpages.room-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Set createdby to authenticated user ID
        $data['createdby'] = auth()->id();

        $roomType = RoomType::create($data);
        
        return redirect()->route('adminpages.room-types.index')
                        ->with('success', 'Room Type created successfully.');
    }

    public function show($id)
    {
        $roomType = RoomType::findOrFail($id);
        return view('adminpages.room-types.show', compact('roomType'));
    }

    public function edit($id)
    {
        $roomType = RoomType::findOrFail($id);
        return view('adminpages.room-types.edit', compact('roomType'));
    }

    public function update(Request $request, $id)
    {
        $roomType = RoomType::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $roomType->update($data);
        
        return redirect()->route('adminpages.room-types.index')
                        ->with('success', 'Room Type updated successfully.');
    }

    public function destroy($id)
    {
        $roomType = RoomType::findOrFail($id);
        $roomType->delete();
        
        return redirect()->route('adminpages.room-types.index')
                        ->with('success', 'Room Type deleted successfully.');
    }
}
