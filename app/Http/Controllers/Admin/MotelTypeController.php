<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use App\Models\MotelType;

class MotelTypeController extends AdminBaseController
{
    public function index(Request $request)
    {
        $query = MotelType::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('createby', 'like', "%{$search}%");
            });
        }
        
        $motelTypes = $query->orderBy('name')->paginate(20);
        
        return view('adminpages.motel-types.index', compact('motelTypes'));
    }

    public function create()
    {
        return view('adminpages.motel-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Set createby to authenticated user ID
        $data['createby'] = auth()->id();

        $motelType = MotelType::create($data);
        
        return redirect()->route('adminpages.motel-types.index')
                        ->with('success', 'Motel Type created successfully.');
    }

    public function show($id)
    {
        $motelType = MotelType::findOrFail($id);
        return view('adminpages.motel-types.show', compact('motelType'));
    }

    public function edit($id)
    {
        $motelType = MotelType::findOrFail($id);
        return view('adminpages.motel-types.edit', compact('motelType'));
    }

    public function update(Request $request, $id)
    {
        $motelType = MotelType::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $motelType->update($data);
        
        return redirect()->route('adminpages.motel-types.index')
                        ->with('success', 'Motel Type updated successfully.');
    }

    public function destroy($id)
    {
        $motelType = MotelType::findOrFail($id);
        $motelType->delete();
        
        return redirect()->route('adminpages.motel-types.index')
                        ->with('success', 'Motel Type deleted successfully.');
    }
}
