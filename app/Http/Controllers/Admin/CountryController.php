<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->paginate(20);
        return view('adminpages.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('adminpages.countries.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'createby' => 'nullable|string',
        ]);

        Country::create($data);

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
            'createby' => 'nullable|string',
        ]);
        $country->update($data);
        return redirect()->route('adminpages.countries.index')->with('success', 'Country updated');
    }

    public function destroy($id)
    {
        Country::findOrFail($id)->delete();
        return redirect()->route('adminpages.countries.index')->with('success', 'Country deleted');
    }
}
