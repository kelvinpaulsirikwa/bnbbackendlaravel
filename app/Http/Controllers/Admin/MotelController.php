<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use App\Models\Motel;
use App\Models\MotelDetail;
use App\Models\BnbUser;
use App\Models\MotelType;
use App\Models\District;
use App\Models\Country;
use App\Models\Region;
use App\Models\BnbRoom;
use App\Models\BnbRoomItem;
use App\Models\BnbRoomImage;
use App\Models\BnbBooking;
use App\Http\Controllers\Website\HomeController;

class MotelController extends AdminBaseController
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
        $regions = Region::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        
        return view('adminpages.motels.create', compact('owners', 'motelTypes', 'districts', 'regions', 'countries'));
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
        
        $motelData['created_by'] = auth()->id();

        $motel = Motel::create($motelData);
        
        // Persist motel details if provided
        $detailsPayload = array_filter([
            'contact_phone' => $detailsData['contact_phone'] ?? null,
            'contact_email' => $detailsData['contact_email'] ?? null,
            'total_rooms' => $detailsData['total_rooms'] ?? null,
            'available_rooms' => $detailsData['available_rooms'] ?? null,
            'status' => $detailsData['status'],
        ], static fn($value) => !is_null($value));

        if (!empty($detailsPayload)) {
            $detailsPayload['motel_id'] = $motel->id;
            MotelDetail::create($detailsPayload);
        }
        
        // Clear statistics cache
        HomeController::clearStatisticsCache();
        
        return redirect()->route('adminpages.motels.index')
                        ->with('success', 'Motel created successfully.');
    }

    public function show($id)
    {
        $motel = Motel::with(['owner', 'motelType', 'creator', 'details', 'district', 'rooms' => fn ($q) => $q->with('roomType')->orderBy('room_number')])
            ->findOrFail($id);
        return view('adminpages.motels.show', compact('motel'));
    }

    /**
     * View a single room (read-only) with paginated items, images, and bookings.
     */
    public function showRoom($motelId, $roomId)
    {
        $motel = Motel::findOrFail($motelId);
        $room = BnbRoom::where('motelid', $motel->id)->where('id', $roomId)->with('roomType')->firstOrFail();

        $roomItems = BnbRoomItem::where('bnbroomid', $room->id)
            ->orderBy('name')
            ->paginate(10, ['*'], 'items_page');

        $roomImages = BnbRoomImage::where('bnbroomid', $room->id)
            ->orderBy('id')
            ->paginate(12, ['*'], 'images_page');

        $bookings = BnbBooking::where('bnb_room_id', $room->id)
            ->with('customer')
            ->latest('check_in_date')
            ->paginate(10, ['*'], 'bookings_page');

        return view('adminpages.motels.rooms.show', compact('motel', 'room', 'roomItems', 'roomImages', 'bookings'));
    }

    public function edit($id)
    {
        $motel = Motel::with(['details', 'district'])->findOrFail($id);
        $owners = BnbUser::whereIn('role', ['bnbowner', 'bnbadmin'])->orderBy('username')->get();
        $motelTypes = MotelType::orderBy('name')->get();
        $districts = District::orderBy('name')->get();
        $regions = Region::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        
        return view('adminpages.motels.edit', compact('motel', 'owners', 'motelTypes', 'districts', 'regions', 'countries'));
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
        
        // Sync motel details record
        $detailsPayload = array_filter([
            'contact_phone' => $detailsData['contact_phone'] ?? null,
            'contact_email' => $detailsData['contact_email'] ?? null,
            'total_rooms' => $detailsData['total_rooms'] ?? null,
            'available_rooms' => $detailsData['available_rooms'] ?? null,
            'status' => $detailsData['status'],
        ], static fn($value) => !is_null($value));
        
        if ($motel->details) {
            $motel->details->update($detailsPayload);
        } elseif (!empty($detailsPayload)) {
            $detailsPayload['motel_id'] = $motel->id;
            MotelDetail::create($detailsPayload);
        }
        
        // Clear statistics cache
        HomeController::clearStatisticsCache();
        
        return redirect()->route('adminpages.motels.index')
                        ->with('success', 'Motel updated successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,closed',
        ]);

        $motel = Motel::with('details')->findOrFail($id);
        $newStatus = $request->input('status');

        // Persist status directly on detail record (fallback create if missing)
        if ($motel->details) {
            $motel->details->update(['status' => $newStatus]);
        } else {
            MotelDetail::create([
                'motel_id' => $motel->id,
                'status' => $newStatus,
            ]);
        }

        return redirect()->back()
            ->with('success', "Motel status updated to {$newStatus}.");
    }

    public function destroy($id)
    {
        $motel = Motel::findOrFail($id);
        if ($motel->details) {
            $motel->details()->update(['status' => 'inactive']);
        } else {
            MotelDetail::create([
                'motel_id' => $motel->id,
                'status' => 'inactive',
            ]);
        }

        return redirect()->back()
            ->with('success', 'Motel has been set to inactive.');
    }
}
