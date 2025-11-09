<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;

use App\Models\Region;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        $query = District::with(['region.country']);
        
        // Filter by region if provided
        if ($request->filled('region_id')) {
            $query->where('regionid', $request->region_id);
        }
        
        // Filter by country if provided
        if ($request->filled('country_id')) {
            $query->whereHas('region', function($q) use ($request) {
                $q->where('countryid', $request->country_id);
            });
        }
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('createdby', 'like', "%{$search}%")
                  ->orWhereHas('region', function($regionQuery) use ($search) {
                      $regionQuery->where('name', 'like', "%{$search}%")
                                  ->orWhereHas('country', function($countryQuery) use ($search) {
                                      $countryQuery->where('name', 'like', "%{$search}%");
                                  });
                  });
            });
        }
        
        $districts = $query->orderBy('name')->paginate(20);
        $regions = Region::with('country')->orderBy('name')->get();
        $countries = \App\Models\Country::orderBy('name')->get();
        
        return view('adminpages.districts.index', compact('districts', 'regions', 'countries'));
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        return view('adminpages.districts.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'regionid' => 'required|integer|exists:regions,id',
            'name' => 'required|string|max:255',
            'createdby' => 'nullable|string',
        ]);

        District::create($data);
        return redirect()->route('adminpages.districts.index')->with('success', 'District created');
    }

    public function edit($id)
    {
        $district = District::findOrFail($id);
        $regions = Region::orderBy('name')->get();
        return view('adminpages.districts.edit', compact('district','regions'));
    }

    public function update(Request $request, $id)
    {
        $district = District::findOrFail($id);
        $data = $request->validate([
            'regionid' => 'required|integer|exists:regions,id',
            'name' => 'required|string|max:255',
            'createdby' => 'nullable|string',
        ]);
        $district->update($data);
        return redirect()->route('adminpages.districts.index')->with('success', 'District updated');
    }

    public function destroy($id)
    {
        District::findOrFail($id)->delete();
        return redirect()->route('adminpages.districts.index')->with('success', 'District deleted');
    }
}
