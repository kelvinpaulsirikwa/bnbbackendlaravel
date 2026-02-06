<?php

namespace App\Http\Controllers\Admin;

use App\Models\HotelOwnerLog;
use App\Models\BnbUser;
use App\Models\Motel;
use Illuminate\Http\Request;

class HotelOwnerLogController extends AdminBaseController
{
    public function index(Request $request)
    {
        $query = HotelOwnerLog::query()->with(['ownerUser', 'ownerUser.motel']);

        if ($request->filled('owner_user_id')) {
            $query->where('owner_user_id', $request->owner_user_id);
        }

        if ($request->filled('motel_id')) {
            $query->whereHas('ownerUser', fn ($q) => $q->where('motel_id', $request->motel_id));
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('method')) {
            $query->where('method', $request->input('method'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('route_name', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'date');
        if ($sort === 'user') {
            $query->orderBy('owner_user_id')->orderBy('created_at', 'desc');
        } elseif ($sort === 'hotel') {
            $query->join('bnb_users', 'hotel_owner_logs.owner_user_id', '=', 'bnb_users.id')
                ->leftJoin('bnb_motels', 'bnb_users.motel_id', '=', 'bnb_motels.id')
                ->orderBy('bnb_motels.name')
                ->orderBy('hotel_owner_logs.created_at', 'desc')
                ->select('hotel_owner_logs.*');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $logs = $query->paginate(20)->withQueryString();

        $ownerUsers = BnbUser::whereIn('role', ['bnbowner', 'bnbonwner'])
            ->orderBy('username')
            ->get(['id', 'username', 'useremail']);

        $motels = Motel::orderBy('name')->get(['id', 'name']);

        return view('adminpages.hotel-owner-logs.index', compact('logs', 'ownerUsers', 'motels'));
    }

    public function show(HotelOwnerLog $hotel_owner_log)
    {
        $hotel_owner_log->load('ownerUser');
        return view('adminpages.hotel-owner-logs.show', compact('hotel_owner_log'));
    }
}
