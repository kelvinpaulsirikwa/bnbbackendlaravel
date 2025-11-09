<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motel;
use App\Models\MotelDetail;
use App\Models\BnbUser;
use App\Models\MotelType;
use App\Models\District;

class MotelController extends Controller
{
    public function index(Request $request)
    {
        $query = Motel::with(['owner', 'motelType', 'creator', 'details', 'district']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('street_address', 'like', "%{$search}%")
                  ->orWhereHas('details', function($detailQuery) use ($search) {
                      $detailQuery->where('contact_phone', 'like', "%{$search}%")
                                 ->orWhere('contact_email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->whereHas('details', function($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Filter by motel type
        if ($request->filled('motel_type_id')) {
            $query->where('motel_type_id', $request->motel_type_id);
        }
        
        $motels = $query->orderBy('name')->paginate(20);
        $motelTypes = MotelType::orderBy('name')->get();
        
        return view('adminpages.motels.index', compact('motels', 'motelTypes'));
    }

    public function create()
    {
        $owners = BnbUser::whereIn('role', ['bnbowner', 'bnbadmin'])->orderBy('username')->get();
        $motelTypes = MotelType::orderBy('name')->get();
        $districts = District::orderBy('name')->get();
        
        return view('adminpages.motels.create', compact('owners', 'motelTypes', 'districts'));
    }

    public function store(Request $request)
    {
        $motelData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:bnb_users,id',
            'motel_type_id' => 'nullable|exists:motel_types,id',
            'street_address' => 'nullable|string|max:255',
            'district_id' => 'nullable|exists:districts,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'front_image' => 'nullable|string|max:255',
        ]);

        $detailsData = $request->validate([
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:100',
            'total_rooms' => 'nullable|integer|min:0',
            'available_rooms' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive,closed',
        ]);

        // Set created_by to authenticated user ID
        $motelData['created_by'] = auth()->id();

        $motel = Motel::create($motelData);
        
        // Create motel details
        $detailsData['motel_id'] = $motel->id;
        MotelDetail::create($detailsData);
        
        return redirect()->route('adminpages.motels.index')
                        ->with('success', 'Motel created successfully.');
    }

    public function show($id)
    {
        $motel = Motel::with(['owner', 'motelType', 'creator', 'details', 'district'])->findOrFail($id);
        return view('adminpages.motels.show', compact('motel'));
    }

    public function edit($id)
    {
        $motel = Motel::with('details')->findOrFail($id);
        $owners = BnbUser::whereIn('role', ['bnbowner', 'bnbadmin'])->orderBy('username')->get();
        $motelTypes = MotelType::orderBy('name')->get();
        $districts = District::orderBy('name')->get();
        
        return view('adminpages.motels.edit', compact('motel', 'owners', 'motelTypes', 'districts'));
    }

    public function update(Request $request, $id)
    {
        $motel = Motel::with('details')->findOrFail($id);
        
        $motelData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:bnb_users,id',
            'motel_type_id' => 'nullable|exists:motel_types,id',
            'street_address' => 'nullable|string|max:255',
            'district_id' => 'nullable|exists:districts,id',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'front_image' => 'nullable|string|max:255',
        ]);

        $detailsData = $request->validate([
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:100',
            'total_rooms' => 'nullable|integer|min:0',
            'available_rooms' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive,closed',
        ]);
        
        $motel->update($motelData);
        
        // Update or create motel details
        if ($motel->details) {
            $motel->details->update($detailsData);
        } else {
            $detailsData['motel_id'] = $motel->id;
            MotelDetail::create($detailsData);
        }
        
        return redirect()->route('adminpages.motels.index')
                        ->with('success', 'Motel updated successfully.');
    }

    public function destroy($id)
    {
        $motel = Motel::findOrFail($id);
        $motel->delete();
        
        return redirect()->route('adminpages.motels.index')
                        ->with('success', 'Motel deleted successfully.');
    }
}
