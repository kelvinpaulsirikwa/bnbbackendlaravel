<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;

use App\Models\Country;

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
            'createdby' => 'nullable|string',
        ]);

        Region::create($data);
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
            'createdby' => 'nullable|string',
        ]);
        $region->update($data);
        return redirect()->route('adminpages.regions.index')->with('success', 'Region updated');
    }

    public function destroy($id)
    {
        Region::findOrFail($id)->delete();
        return redirect()->route('adminpages.regions.index')->with('success', 'Region deleted');
    }
}
