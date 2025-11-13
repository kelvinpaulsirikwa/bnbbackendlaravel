<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Website\HomeController;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        $query = Region::with('country');
        
        // Filter by country if provided
        if ($request->filled('country_id')) {
            $query->where('countryid', $request->country_id);
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('createdby', 'like', "%{$search}%")
                  ->orWhereHas('country', function($countryQuery) use ($search) {
                      $countryQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        $regions = $query->orderBy('name')->paginate(20);
        $countries = Country::orderBy('name')->get();
        
        return view('adminpages.regions.index', compact('regions', 'countries'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('adminpages.regions.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'countryid' => 'required|integer|exists:countries,id',
            'name' => 'required|string|max:255',
        ]);

        $data['createdby'] = optional(Auth::user())->username
            ?? optional(Auth::user())->useremail
            ?? optional(Auth::user())->name
            ?? 'System';

        Region::create($data);
        
        // Clear statistics cache
        HomeController::clearStatisticsCache();
        
        return redirect()->route('adminpages.regions.index')->with('success', 'Region created');
    }

    public function edit($id)
    {
        $region = Region::findOrFail($id);
        $countries = Country::orderBy('name')->get();
        return view('adminpages.regions.edit', compact('region','countries'));
    }

    public function update(Request $request, $id)
    {
        $region = Region::findOrFail($id);
        $data = $request->validate([
            'countryid' => 'required|integer|exists:countries,id',
            'name' => 'required|string|max:255',
        ]);
        $region->update($data);
        
        // Clear statistics cache
        HomeController::clearStatisticsCache();
        
        return redirect()->route('adminpages.regions.index')->with('success', 'Region updated');
    }

    public function destroy($id)
    {
        $region = Region::withCount('districts')->findOrFail($id);

        if ($region->districts_count > 0) {
            return redirect()
                ->route('adminpages.regions.index')
                ->with('error', 'Region cannot be deleted while districts are associated with it.');
        }

        $region->delete();
        
        // Clear statistics cache
        HomeController::clearStatisticsCache();
        
        return redirect()->route('adminpages.regions.index')->with('success', 'Region deleted');
    }
}
