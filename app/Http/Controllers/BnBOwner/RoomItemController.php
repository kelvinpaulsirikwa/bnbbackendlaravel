<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Motel;
use App\Models\BnbRoom;
use App\Models\BnbRoomItem;

class RoomItemController extends Controller
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
        
        $items = BnbRoomItem::where('bnbroomid', $roomId)->get();
        
        return view('bnbowner.room-items.index', compact('motel', 'room', 'items'))->with('selectedMotel', $motel);
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
        
        return view('bnbowner.room-items.create', compact('motel', 'room'))->with('selectedMotel', $motel);
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
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);
        
        BnbRoomItem::create([
            'bnbroomid' => $roomId,
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => $user->id
        ]);
        
        return redirect()->route('bnbowner.room-items.index', $roomId)
                       ->with('success', 'Room item created successfully.');
    }
    
    public function edit($roomId, $itemId)
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
        
        $item = BnbRoomItem::where('id', $itemId)
                          ->where('bnbroomid', $roomId)
                          ->first();
        
        if (!$item) {
            return redirect()->back()->with('error', 'Room item not found.');
        }
        
        return view('bnbowner.room-items.edit', compact('motel', 'room', 'item'))->with('selectedMotel', $motel);
    }
    
    public function update(Request $request, $roomId, $itemId)
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
        
        $item = BnbRoomItem::where('id', $itemId)
                          ->where('bnbroomid', $roomId)
                          ->first();
        
        if (!$item) {
            return redirect()->back()->with('error', 'Room item not found.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string'
        ]);
        
        $item->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        
        return redirect()->route('bnbowner.room-items.index', $roomId)
                       ->with('success', 'Room item updated successfully.');
    }
    
    public function destroy($roomId, $itemId)
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
        
        $item = BnbRoomItem::where('id', $itemId)
                          ->where('bnbroomid', $roomId)
                          ->first();
        
        if (!$item) {
            return redirect()->back()->with('error', 'Room item not found.');
        }
        
        $item->delete();
        
        return redirect()->route('bnbowner.room-items.index', $roomId)
                       ->with('success', 'Room item deleted successfully.');
    }
}
