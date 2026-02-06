<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Motel;
use App\Models\BnbRoom;
use App\Models\RoomType;

class RoomManagementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        if (!$selectedMotelId) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $rooms = BnbRoom::where('motelid', $motel->id)
                       ->with(['roomType', 'items', 'images'])
                       ->get();
        
        $roomTypes = RoomType::all();
        
        return view('bnbowner.room-management.index', compact('motel', 'rooms', 'roomTypes'))->with('selectedMotel', $motel);
    }
    
    public function create()
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        if (!$selectedMotelId) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $roomTypes = RoomType::all();
        $totalRooms = optional($motel->details)->total_rooms;
        $currentRooms = BnbRoom::where('motelid', $motel->id)->count();

        if (!is_null($totalRooms) && $currentRooms >= (int) $totalRooms) {
            return redirect()
                ->route('bnbowner.room-management.index')
                ->with('error', 'You have reached the maximum number of rooms allowed for this motel.');
        }
        
        return view('bnbowner.room-management.create', compact('motel', 'roomTypes'))->with('selectedMotel', $motel);
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $totalRooms = optional($motel->details)->total_rooms;
        $currentRooms = BnbRoom::where('motelid', $motel->id)->count();

        if (!is_null($totalRooms) && $currentRooms >= (int) $totalRooms) {
            return redirect()
                ->route('bnbowner.room-management.index')
                ->with('error', 'You cannot add more rooms than the total allowed for this motel.');
        }

        $request->validate([
            'room_number' => 'required|string|max:50',
            'room_type_id' => 'required|exists:room_types,id',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:free,booked,maintainace',
            'frontimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = $request->only(['room_number', 'room_type_id', 'price_per_night', 'status']);
        $data['motelid'] = $motel->id;
        $data['created_by'] = $user->id;
        
        // Handle image upload
        if ($request->hasFile('frontimage')) {
            $imagePath = $request->file('frontimage')->store('rooms', 'public');
            $data['frontimage'] = $imagePath;
        }
        
        BnbRoom::create($data);
        
        return redirect()->route('bnbowner.room-management.index')
                       ->with('success', 'Room created successfully.');
    }
    
    public function edit($id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $room = BnbRoom::where('id', $id)
                      ->where('motelid', $motel->id)
                      ->with(['roomType', 'items', 'images'])
                      ->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        
        $roomTypes = RoomType::all();
        
        return view('bnbowner.room-management.edit', compact('motel', 'room', 'roomTypes'))->with('selectedMotel', $motel);
    }
    
    public function show($id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $room = BnbRoom::where('id', $id)
                      ->where('motelid', $motel->id)
                      ->with(['roomType', 'items', 'images'])
                      ->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        
        return view('bnbowner.room-management.show', compact('motel', 'room'))->with('selectedMotel', $motel);
    }
    
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $room = BnbRoom::where('id', $id)
                      ->where('motelid', $motel->id)
                      ->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        
        $request->validate([
            'room_number' => 'required|string|max:50',
            'room_type_id' => 'required|exists:room_types,id',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:free,booked,maintainace',
            'frontimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = $request->only(['room_number', 'room_type_id', 'price_per_night', 'status']);
        
        // Handle image upload
        if ($request->hasFile('frontimage')) {
            // Delete old image if exists
            if ($room->frontimage && Storage::exists('public/' . $room->frontimage)) {
                Storage::delete('public/' . $room->frontimage);
            }
            
            $imagePath = $request->file('frontimage')->store('rooms', 'public');
            $data['frontimage'] = $imagePath;
        }
        
        $room->update($data);
        
        return redirect()->route('bnbowner.room-management.index')
                       ->with('success', 'Room updated successfully.');
    }
    
    public function destroy($id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $room = BnbRoom::where('id', $id)
                      ->where('motelid', $motel->id)
                      ->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        
        // Delete associated images
        foreach ($room->images as $image) {
            if ($image->imagepath && Storage::exists('public/' . $image->imagepath)) {
                Storage::delete('public/' . $image->imagepath);
            }
        }
        
        // Delete room front image
        if ($room->frontimage && Storage::exists('public/' . $room->frontimage)) {
            Storage::delete('public/' . $room->frontimage);
        }
        
        $room->delete();
        
        return redirect()->route('bnbowner.room-management.index')
                       ->with('success', 'Room deleted successfully.');
    }
}
