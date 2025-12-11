<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BnbRule;
use App\Models\Motel;

class BnbRuleController extends Controller
{
    /**
     * Display the rules management page
     */
    public function index()
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        if (!$selectedMotelId) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $bnbRule = BnbRule::where('motel_id', $motel->id)->first();
        
        return view('bnbowner.bnb-rules.index', compact('motel', 'bnbRule'));
    }

    /**
     * Store or update rules
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $request->validate([
            'rules' => 'nullable|string'
        ]);
        
        $bnbRule = BnbRule::where('motel_id', $motel->id)->first();
        
        if ($bnbRule) {
            $bnbRule->update([
                'rules' => $request->rules,
                'posted_by' => $user->id
            ]);
            $message = 'Rules updated successfully.';
        } else {
            BnbRule::create([
                'motel_id' => $motel->id,
                'rules' => $request->rules,
                'posted_by' => $user->id
            ]);
            $message = 'Rules created successfully.';
        }
        
        return redirect()->back()->with('success', $message);
    }

    /**
     * Update rules
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $bnbRule = BnbRule::where('id', $id)
                         ->where('motel_id', $motel->id)
                         ->firstOrFail();
        
        $request->validate([
            'rules' => 'nullable|string'
        ]);
        
        $bnbRule->update([
            'rules' => $request->rules,
            'posted_by' => $user->id
        ]);
        
        return redirect()->back()->with('success', 'Rules updated successfully.');
    }

    /**
     * Delete rules
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        if (!$selectedMotelId) {
            return redirect()->route('bnbowner.motel-selection')->with('error', 'Please select a motel first.');
        }
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $bnbRule = BnbRule::where('id', $id)
                         ->where('motel_id', $motel->id)
                         ->first();
        
        if (!$bnbRule) {
            return redirect()->back()->with('error', 'Rules not found.');
        }
        
        $bnbRule->delete();
        
        return redirect()->route('bnbowner.bnb-rules.index')->with('success', 'Rules deleted successfully.');
    }
}
