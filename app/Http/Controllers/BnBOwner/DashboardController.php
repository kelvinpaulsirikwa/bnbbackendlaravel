<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Motel;
use App\Models\BnbUser;

class DashboardController extends Controller
{
    public function motelSelection()
    {
        $user = Auth::user();
        
        // Get all motels owned by this user
        $motels = Motel::where('owner_id', $user->id)
                      ->with(['district', 'motelType'])
                      ->get();
        
        return view('bnbowner.motel-selection', compact('motels', 'user'));
    }
    
    public function index()
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        if (!$selectedMotelId) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        // Get the selected motel
        $selectedMotel = Motel::where('id', $selectedMotelId)
                            ->where('owner_id', $user->id)
                            ->with(['district', 'motelType', 'amenities', 'details'])
                            ->first();
        
        if (!$selectedMotel) {
            session()->forget('selected_motel_id');
            return redirect()->route('bnbowner.motel-selection');
        }
        
        // Get all motels for switch account dropdown
        $allMotels = Motel::where('owner_id', $user->id)->get();
        
        return view('bnbowner.dashboard', compact('selectedMotel', 'allMotels', 'user'));
    }
    
    public function selectMotel(Request $request)
    {
        $motelId = $request->input('motel_id');
        $user = Auth::user();
        
        // Verify the motel belongs to the user
        $motel = Motel::where('id', $motelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found or access denied.');
        }
        
        // Store selected motel in session
        session(['selected_motel_id' => $motelId]);
        
        return redirect()->route('bnbowner.dashboard')->with('success', 'Motel selected successfully.');
    }
    
    public function switchAccount()
    {
        // Clear the selected motel from session
        session()->forget('selected_motel_id');
        
        return redirect()->route('bnbowner.motel-selection');
    }
}
