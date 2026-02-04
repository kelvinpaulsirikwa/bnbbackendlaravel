<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Http\Controllers\Website\HomeController;

class CountryController extends AdminBaseController
{
    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->paginate(20);
        return view('adminpages.countries.index', compact('countries'));
    }

    public function create()
    {
        $user = Auth::user();

        return view('adminpages.countries.create', compact('user'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $data['createby'] = optional(Auth::user())->username
            ?? optional(Auth::user())->useremail
            ?? optional(Auth::user())->name
            ?? 'System';

        Country::create($data);
        
        // Clear statistics cache
        HomeController::clearStatisticsCache();

        return redirect()->route('adminpages.countries.index')->with('success', 'Country created');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view('adminpages.countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $country->update($data);
        
        // Clear statistics cache
        HomeController::clearStatisticsCache();
        
        return redirect()->route('adminpages.countries.index')->with('success', 'Country updated');
    }

    public function destroy($id)
    {
        $country = Country::withCount('regions')->findOrFail($id);

        if ($country->regions_count > 0) {
            return redirect()
                ->route('adminpages.countries.index')
                ->with('error', 'Country cannot be deleted while regions are associated with it.');
        }

        $country->delete();
        
        // Clear statistics cache
        HomeController::clearStatisticsCache();

        return redirect()->route('adminpages.countries.index')->with('success', 'Country deleted');
    }
}
