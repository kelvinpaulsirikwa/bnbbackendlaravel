<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use App\Models\TermsOfService;

class TermsOfServiceController extends AdminBaseController
{
    public function index(Request $request)
    {
        $query = TermsOfService::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $terms = $query->with('creator')->orderBy('updated_at', 'desc')->paginate(15);

        return view('adminpages.terms-of-service.index', compact('terms'));
    }

    public function create()
    {
        return view('adminpages.terms-of-service.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['created_by'] = auth()->id();

        if ($data['is_active']) {
            TermsOfService::where('id', '>', 0)->update(['is_active' => false]);
        }

        TermsOfService::create($data);

        return redirect()->route('adminpages.terms-of-service.index')
            ->with('success', 'Terms of Service created successfully.');
    }

    public function show($id)
    {
        $term = TermsOfService::with('creator')->findOrFail($id);
        return view('adminpages.terms-of-service.show', compact('term'));
    }

    public function edit($id)
    {
        $term = TermsOfService::findOrFail($id);
        return view('adminpages.terms-of-service.edit', compact('term'));
    }

    public function update(Request $request, $id)
    {
        $term = TermsOfService::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($data['is_active']) {
            TermsOfService::where('id', '!=', $id)->update(['is_active' => false]);
        }

        $term->update($data);

        return redirect()->route('adminpages.terms-of-service.index')
            ->with('success', 'Terms of Service updated successfully.');
    }

    public function destroy($id)
    {
        $term = TermsOfService::findOrFail($id);
        $term->delete();

        return redirect()->route('adminpages.terms-of-service.index')
            ->with('success', 'Terms of Service deleted successfully.');
    }
}
