<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BnbUser;
use App\Models\Customer;
use App\Models\Country;
use App\Models\Region;
use App\Models\District;
use App\Models\Motel;
use App\Models\MotelDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $startOfMonth = Carbon::now()->startOfMonth();

        // BnB Users Statistics
        $bnbUserStats = [
            'total' => BnbUser::count(),
            'active' => BnbUser::where('status', 'active')->count(),
            'inactive' => BnbUser::where('status', '!=', 'active')->count(),
            'today' => BnbUser::whereDate('created_at', $today)->count(),
            'yesterday' => BnbUser::whereDate('created_at', $yesterday)->count(),
            'this_month' => BnbUser::where('created_at', '>=', $startOfMonth)->count(),
            'website_registrations' => BnbUser::where('createdby', 'websiteregistration')->count(),
        ];

        // Users by Role
        $usersByRole = [
            'bnbadmin' => BnbUser::where('role', 'bnbadmin')->count(),
            'bnbowner' => BnbUser::whereIn('role', ['bnbowner', 'bnbonwner'])->count(),
            'receptionist' => BnbUser::where('role', 'receptionist')->count(),
            'security' => BnbUser::where('role', 'security')->count(),
            'chef' => BnbUser::where('role', 'chef')->count(),
        ];

        // Customer Statistics
        $customerStats = [
            'total' => Customer::count(),
            'today' => Customer::whereDate('created_at', $today)->count(),
            'yesterday' => Customer::whereDate('created_at', $yesterday)->count(),
            'this_month' => Customer::where('created_at', '>=', $startOfMonth)->count(),
        ];

        // Location Statistics
        $locationStats = [
            'countries' => Country::count(),
            'regions' => Region::count(),
            'districts' => District::count(),
        ];

        // Motel Statistics
        $motelStats = [
            'total' => Motel::count(),
            'active' => MotelDetail::where('status', 'active')->count(),
            'inactive' => MotelDetail::where('status', 'inactive')->count(),
            'pending' => MotelDetail::where('status', 'pending')->count(),
        ];

        // Recent Pending Motels (for admin approval)
        $pendingMotels = Motel::whereHas('details', function ($q) {
            $q->where('status', 'inactive');
        })->with(['owner', 'motelType', 'district'])
          ->latest()
          ->take(5)
          ->get();

        // Recent Website Registrations
        $recentRegistrations = BnbUser::where('createdby', 'websiteregistration')
            ->latest()
            ->take(5)
            ->get();

        return view('adminpages.dashboard', compact(
            'bnbUserStats',
            'usersByRole',
            'customerStats',
            'locationStats',
            'motelStats',
            'pendingMotels',
            'recentRegistrations'
        ));
    }
}
