<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Motel;
use App\Models\BnbRoom;
use App\Models\BnbRoomImage;

class RoomImageController extends Controller
{
    public function index($roomId)
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
        
        $room = BnbRoom::where('id', $roomId)
                      ->where('motelid', $motel->id)
                      ->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        
        $images = BnbRoomImage::where('bnbroomid', $roomId)->get();
        
        return view('bnbowner.room-images.index', compact('motel', 'room', 'images'))->with('selectedMotel', $motel);
    }
    
    public function create($roomId)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $room = BnbRoom::where('id', $roomId)
                      ->where('motelid', $motel->id)
                      ->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        
        return view('bnbowner.room-images.create', compact('motel', 'room'))->with('selectedMotel', $motel);
    }
    
    public function store(Request $request, $roomId)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $room = BnbRoom::where('id', $roomId)
                      ->where('motelid', $motel->id)
                      ->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        
        $request->validate([
            'imagepath' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string'
        ]);
        
        $imagePath = $request->file('imagepath')->store('room-images', 'public');
        
        BnbRoomImage::create([
            'bnbroomid' => $roomId,
            'imagepath' => $imagePath,
            'description' => $request->description,
            'created_by' => $user->id
        ]);
        
        return redirect()->route('bnbowner.room-images.index', $roomId)
                       ->with('success', 'Room image uploaded successfully.');
    }
    
    public function edit($roomId, $imageId)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $room = BnbRoom::where('id', $roomId)
                      ->where('motelid', $motel->id)
                      ->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        
        $image = BnbRoomImage::where('id', $imageId)
                            ->where('bnbroomid', $roomId)
                            ->first();
        
        if (!$image) {
            return redirect()->back()->with('error', 'Room image not found.');
        }
        
        return view('bnbowner.room-images.edit', compact('motel', 'room', 'image'))->with('selectedMotel', $motel);
    }
    
    public function update(Request $request, $roomId, $imageId)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $room = BnbRoom::where('id', $roomId)
                      ->where('motelid', $motel->id)
                      ->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        
        $image = BnbRoomImage::where('id', $imageId)
                            ->where('bnbroomid', $roomId)
                            ->first();
        
        if (!$image) {
            return redirect()->back()->with('error', 'Room image not found.');
        }
        
        $request->validate([
            'imagepath' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string'
        ]);
        
        $data = ['description' => $request->description];
        
        // Handle image upload
        if ($request->hasFile('imagepath')) {
            // Delete old image if exists
            if ($image->imagepath && Storage::exists('public/' . $image->imagepath)) {
                Storage::delete('public/' . $image->imagepath);
            }
            
            $imagePath = $request->file('imagepath')->store('room-images', 'public');
            $data['imagepath'] = $imagePath;
        }
        
        $image->update($data);
        
        return redirect()->route('bnbowner.room-images.index', $roomId)
                       ->with('success', 'Room image updated successfully.');
    }
    
    public function destroy($roomId, $imageId)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $room = BnbRoom::where('id', $roomId)
                      ->where('motelid', $motel->id)
                      ->first();
        
        if (!$room) {
            return redirect()->back()->with('error', 'Room not found.');
        }
        
        $image = BnbRoomImage::where('id', $imageId)
                            ->where('bnbroomid', $roomId)
                            ->first();
        
        if (!$image) {
            return redirect()->back()->with('error', 'Room image not found.');
        }
        
        // Delete image file
        if ($image->imagepath && Storage::exists('public/' . $image->imagepath)) {
            Storage::delete('public/' . $image->imagepath);
        }
        
        $image->delete();
        
        return redirect()->route('bnbowner.room-images.index', $roomId)
                       ->with('success', 'Room image deleted successfully.');
    }
}
