<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use App\Support\OwnerLogMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Motel;
use App\Models\MotelDetail;

class HotelManagementController extends Controller
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
                     ->with(['details'])
                     ->first();
        
        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        return view('bnbowner.hotel-management.index', compact('motel'))->with('selectedMotel', $motel);
    }
    
    public function updateMotel(Request $request)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = $request->only(['name', 'description']);
        $oldValues = $motel->only(['name', 'description', 'front_image']);

        // Handle image upload
        if ($request->hasFile('front_image')) {
            // Delete old image if exists
            if ($motel->front_image && Storage::exists('public/' . $motel->front_image)) {
                Storage::delete('public/' . $motel->front_image);
            }
            $imagePath = $request->file('front_image')->store('motels', 'public');
            $data['front_image'] = $imagePath;
        }

        $motel->update($data);
        OwnerLogMeta::describe(
            "Updated hotel: {$motel->name}",
            'motel',
            $motel->id,
            $oldValues,
            array_merge($data, ['front_image' => $data['front_image'] ?? $motel->front_image])
        );

        return redirect()->back()->with('success', 'Motel information updated successfully.');
    }
    
    public function updateMotelDetails(Request $request)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $request->validate([
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255'
        ]);
        
        $motelDetail = MotelDetail::where('motel_id', $motel->id)->first();
        
        if (!$motelDetail) {
            $motelDetail = MotelDetail::create([
                'motel_id' => $motel->id,
                'contact_phone' => $request->contact_phone,
                'contact_email' => $request->contact_email,
                'total_rooms' => 0,
                'available_rooms' => 0,
                'status' => 'active'
            ]);
        } else {
            $oldValues = $motelDetail->only(['contact_phone', 'contact_email']);
            $motelDetail->update([
                'contact_phone' => $request->contact_phone,
                'contact_email' => $request->contact_email
            ]);
            OwnerLogMeta::describe(
                'Updated hotel contact details',
                'motel_detail',
                $motelDetail->id,
                $oldValues,
                ['contact_phone' => $request->contact_phone, 'contact_email' => $request->contact_email]
            );
        }

        return redirect()->back()->with('success', 'Contact information updated successfully.');
    }
}
