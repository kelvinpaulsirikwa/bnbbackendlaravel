<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BnbRule;
use App\Models\Motel;

class BnbRuleController extends Controller
{
    /**
     * Display all BNB rules
     */
    public function index(Request $request)
    {
        $query = BnbRule::with(['motel.owner', 'motel.details', 'postedBy']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('rules', 'like', "%{$search}%")
                  ->orWhereHas('motel', function($motelQuery) use ($search) {
                      $motelQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('description', 'like', "%{$search}%");
                  });
            });
        }
        
        $rules = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('adminpages.bnb-rules.index', compact('rules'));
    }

    /**
     * Show specific BNB rule
     */
    public function show($id)
    {
        $bnbRule = BnbRule::with(['motel.owner', 'motel.details', 'motel.motelType', 'postedBy'])->findOrFail($id);
        
        return view('adminpages.bnb-rules.show', compact('bnbRule'));
    }
}
