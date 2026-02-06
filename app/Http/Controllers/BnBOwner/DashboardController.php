<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use App\Models\HotelOwnerLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Motel;
use App\Models\MotelDetail;
use App\Models\MotelType;
use App\Models\Country;
use App\Models\Region;
use App\Models\District;
use App\Models\BnbUser;

class DashboardController extends Controller
{
    public function motelSelection()
    {
        $user = Auth::user();
        
        // Get all motels owned by this user
        $motels = Motel::where('owner_id', $user->id)
                      ->with(['district', 'motelType', 'details'])
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
        
        // Get the selected motel with all relationships
        $selectedMotel = Motel::where('id', $selectedMotelId)
                            ->where('owner_id', $user->id)
                            ->with(['district.region', 'motelType', 'amenities.amenity', 'details', 'rooms', 'images'])
                            ->first();
        
        if (!$selectedMotel) {
            session()->forget('selected_motel_id');
            return redirect()->route('bnbowner.motel-selection');
        }
        
        // Get all motels for switch account dropdown
        $allMotels = Motel::where('owner_id', $user->id)->get();
        
        // Calculate motel statistics
        $motelStats = [
            'created_at' => $selectedMotel->created_at,
            'total_rooms' => $selectedMotel->rooms->count(),
            'available_rooms' => $selectedMotel->details->available_rooms ?? 0,
            'total_amenities' => $selectedMotel->amenities->count(),
            'total_images' => $selectedMotel->images->count(),
            'total_staff' => BnbUser::where('motel_id', $selectedMotel->id)
                                   ->whereIn('role', ['bnbreceiptionist', 'bnbsecurity', 'bnbchef'])
                                   ->count(),
        ];
        
        return view('bnbowner.dashboard', compact('selectedMotel', 'allMotels', 'user', 'motelStats'));
    }

    /**
     * My Dashboard – summary of THIS owner's contributions (from hotel owner logs).
     */
    public function authenticatedUsersSummary()
    {
        $user = Auth::user();

        $baseQuery = HotelOwnerLog::where('owner_user_id', $user->id);

        $totalActions = (clone $baseQuery)->count();
        $created = (clone $baseQuery)->where('method', 'POST')->count();
        $updated = (clone $baseQuery)->whereIn('method', ['PUT', 'PATCH'])->count();
        $deleted = (clone $baseQuery)->where('method', 'DELETE')->count();

        $last30 = now()->subDays(30);
        $last30Actions = (clone $baseQuery)->where('created_at', '>=', $last30)->count();

        $topAreas = (clone $baseQuery)
            ->selectRaw("COALESCE(subject_type, route_name, 'other') as area, COUNT(*) as count")
            ->groupBy('area')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        $recentLogs = (clone $baseQuery)
            ->latest('created_at')
            ->take(10)
            ->get([
                'id',
                'description',
                'action',
                'method',
                'route_name',
                'subject_type',
                'subject_id',
                'created_at',
            ]);

        return view('bnbowner.authenticated-users-summary', compact(
            'user',
            'totalActions',
            'created',
            'updated',
            'deleted',
            'last30Actions',
            'topAreas',
            'recentLogs'
        ));
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
        
        // Check if motel is active
        if ($motel->status !== 'active') {
            return redirect()->back()->with('error', 'This motel is still pending approval. You cannot manage it until it is activated.');
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

    /**
     * Show the form for creating a new motel
     */
    public function createMotel()
    {
        $motelTypes = MotelType::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        $districts = District::orderBy('name')->get();

        return view('bnbowner.motel-create', compact(
            'motelTypes',
            'countries',
            'regions',
            'districts'
        ));
    }

    /**
     * Store a newly created motel
     */
    public function storeMotel(Request $request)
    {
        $user = Auth::user();

        // Validate motel data
        $motelData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'motel_type_id' => 'required|exists:motel_types,id',
            'street_address' => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Validate motel details
        $detailsData = $request->validate([
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'nullable|email|max:100',
            'total_rooms' => 'required|integer|min:1',
            'available_rooms' => 'nullable|integer|min:0',
        ]);

        try {
            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('front_image')) {
                $imagePath = $request->file('front_image')->store('motels', 'public');
            }

            // Create the motel
            $motel = Motel::create([
                'name' => $motelData['name'],
                'description' => $motelData['description'] ?? null,
                'owner_id' => $user->id,
                'motel_type_id' => $motelData['motel_type_id'],
                'street_address' => $motelData['street_address'],
                'district_id' => $motelData['district_id'],
                'latitude' => $motelData['latitude'] ?? null,
                'longitude' => $motelData['longitude'] ?? null,
                'front_image' => $imagePath,
                'created_by' => $user->id,
            ]);

            // Create the motel details with status = 'inactive'
            MotelDetail::create([
                'motel_id' => $motel->id,
                'contact_phone' => $detailsData['contact_phone'],
                'contact_email' => $detailsData['contact_email'] ?? null,
                'total_rooms' => $detailsData['total_rooms'],
                'available_rooms' => $detailsData['available_rooms'] ?? $detailsData['total_rooms'],
                'status' => 'inactive', // Set status to inactive, pending admin approval
            ]);

            return redirect()
                ->route('bnbowner.motel-selection')
                ->with('success', 'Your motel "' . $motel->name . '" has been submitted successfully! It is currently pending admin approval. You will be notified once it is activated.');

        } catch (\Exception $e) {
            // If image was uploaded but motel creation failed, delete the image
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occurred while creating your motel. Please try again.');
        }
    }
}
