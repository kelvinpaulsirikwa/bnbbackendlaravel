<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Amenity;
use App\Models\BnbAmenity;
use App\Models\BnbAmenityImage;
use App\Models\Motel;

class AmenityManagementController extends Controller
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
            ->with([
                'amenities.amenity',
                'amenities.postedBy',
                'amenities.images.postedBy'
            ])
            ->first();

        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }

        $amenities = Amenity::orderBy('name')->get();

        $assignedAmenityIds = $motel->amenities->pluck('amenities_id')->toArray();

        return view('bnbowner.hotel-facilities.index', [
            'motel' => $motel,
            'amenities' => $amenities,
            'assignedAmenityIds' => $assignedAmenityIds,
        ])->with('selectedMotel', $motel);
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

        $data = $request->validate([
            'amenities_id' => 'required|exists:amenities,id',
            'description' => 'nullable|string|max:500',
        ]);

        $alreadyAssigned = BnbAmenity::where('bnb_motels_id', $motel->id)
            ->where('amenities_id', $data['amenities_id'])
            ->exists();

        if ($alreadyAssigned) {
            return redirect()
                ->back()
                ->with('error', 'This amenity is already assigned to your motel.');
        }

        BnbAmenity::create([
            'amenities_id' => $data['amenities_id'],
            'bnb_motels_id' => $motel->id,
            'description' => $data['description'] ?? null,
            'posted_by' => $user->id,
        ]);

        return redirect()
            ->route('bnbowner.hotel-facilities.index')
            ->with('success', 'Amenity added successfully.');
    }

    public function destroy($amenityId)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');

        $motel = Motel::where('id', $selectedMotelId)
            ->where('owner_id', $user->id)
            ->first();

        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }

        $amenity = BnbAmenity::where('id', $amenityId)
            ->where('bnb_motels_id', $motel->id)
            ->with('images')
            ->first();

        if (!$amenity) {
            return redirect()->back()->with('error', 'Amenity not found.');
        }

        foreach ($amenity->images as $image) {
            if ($image->filepath && Storage::disk('public')->exists($image->filepath)) {
                Storage::disk('public')->delete($image->filepath);
            }
            $image->delete();
        }

        $amenity->delete();

        return redirect()
            ->route('bnbowner.hotel-facilities.index')
            ->with('success', 'Amenity removed successfully.');
    }

    public function images($amenityId)
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

        $amenity = BnbAmenity::with(['amenity', 'postedBy', 'images.postedBy'])
            ->where('id', $amenityId)
            ->where('bnb_motels_id', $motel->id)
            ->first();

        if (!$amenity) {
            return redirect()->route('bnbowner.hotel-facilities.index')
                ->with('error', 'Amenity not found.');
        }

        return view('bnbowner.hotel-facilities.images', [
            'motel' => $motel,
            'amenity' => $amenity,
        ])->with('selectedMotel', $motel);
    }

    public function uploadImage(Request $request, $amenityId)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');

        $motel = Motel::where('id', $selectedMotelId)
            ->where('owner_id', $user->id)
            ->first();

        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }

        $amenity = BnbAmenity::where('id', $amenityId)
            ->where('bnb_motels_id', $motel->id)
            ->first();

        if (!$amenity) {
            return redirect()->route('bnbowner.hotel-facilities.index')
                ->with('error', 'Amenity not found.');
        }

        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'description' => 'nullable|string|max:500',
        ]);

        $path = $request->file('image')->store('amenity_images', 'public');

        BnbAmenityImage::create([
            'bnb_amenities_id' => $amenity->id,
            'filepath' => $path,
            'description' => $data['description'] ?? null,
            'posted_by' => $user->id,
        ]);

        return redirect()
            ->route('bnbowner.hotel-facilities.images', $amenity->id)
            ->with('success', 'Image uploaded successfully.');
    }

    public function destroyImage($amenityId, $imageId)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');

        $motel = Motel::where('id', $selectedMotelId)
            ->where('owner_id', $user->id)
            ->first();

        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }

        $amenity = BnbAmenity::where('id', $amenityId)
            ->where('bnb_motels_id', $motel->id)
            ->first();

        if (!$amenity) {
            return redirect()->route('bnbowner.hotel-facilities.index')
                ->with('error', 'Amenity not found.');
        }

        $image = BnbAmenityImage::where('id', $imageId)
            ->where('bnb_amenities_id', $amenity->id)
            ->first();

        if (!$image) {
            return redirect()
                ->route('bnbowner.hotel-facilities.images', $amenity->id)
                ->with('error', 'Amenity image not found.');
        }

        if ($image->filepath && Storage::disk('public')->exists($image->filepath)) {
            Storage::disk('public')->delete($image->filepath);
        }

        $image->delete();

        return redirect()
            ->route('bnbowner.hotel-facilities.images', $amenity->id)
            ->with('success', 'Amenity image removed successfully.');
    }
}

