<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Motel;
use App\Models\BnbImage;

class HotelImageController extends Controller
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

        $images = BnbImage::with('postedBy')
            ->where('bnb_motels_id', $motel->id)
            ->orderByDesc('created_at')
            ->get();

        return view('bnbowner.hotel-images.index', [
            'motel' => $motel,
            'images' => $images,
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $path = $request->file('image')->store('motel_images', 'public');

        BnbImage::create([
            'bnb_motels_id' => $motel->id,
            'filepath' => $path,
            'posted_by' => $user->id,
        ]);

        return redirect()
            ->route('bnbowner.hotel-images.index')
            ->with('success', 'Hotel image uploaded successfully.');
    }

    public function destroy($imageId)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');

        $motel = Motel::where('id', $selectedMotelId)
            ->where('owner_id', $user->id)
            ->first();

        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }

        $image = BnbImage::where('id', $imageId)
            ->where('bnb_motels_id', $motel->id)
            ->first();

        if (!$image) {
            return redirect()
                ->route('bnbowner.hotel-images.index')
                ->with('error', 'Image not found.');
        }

        if ($image->filepath && Storage::disk('public')->exists($image->filepath)) {
            Storage::disk('public')->delete($image->filepath);
        }

        $image->delete();

        return redirect()
            ->route('bnbowner.hotel-images.index')
            ->with('success', 'Hotel image removed successfully.');
    }
}

