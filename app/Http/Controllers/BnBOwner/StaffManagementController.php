<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Motel;
use App\Models\MotelRole;
use App\Models\BnbUser;

class StaffManagementController extends Controller
{
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
        
        // Get all staff members for this motel (staff with motel_id set to this motel)
        $staff = BnbUser::where('motel_id', $motel->id)
                       ->whereIn('role', ['bnbreceiptionist', 'bnbsecurity', 'bnbchef'])
                       ->with('motelRole')
                       ->get();
        
        return view('bnbowner.staff-management.index', compact('motel', 'staff'))->with('selectedMotel', $motel);
    }
    
    public function create()
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $motelRoles = MotelRole::where('motel_id', $motel->id)->orderBy('name')->get();
        return view('bnbowner.staff-management.create', compact('motel', 'motelRoles'))->with('selectedMotel', $motel);
    }
    
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
            'username' => 'required|string|max:255',
            'useremail' => 'required|email|unique:bnb_users,useremail|max:255',
            'password' => 'required|string|min:6|confirmed',
            'telephone' => 'nullable|string|max:20',
            'motel_role_id' => 'nullable|exists:motel_roles,id',
            'profileimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['username', 'useremail', 'telephone', 'motel_role_id']);
        if (!empty($data['motel_role_id'])) {
            $roleBelongsToMotel = MotelRole::where('id', $data['motel_role_id'])->where('motel_id', $motel->id)->exists();
            if (!$roleBelongsToMotel) {
                return redirect()->back()->withInput()->with('error', 'Selected role is not valid for this motel.');
            }
        } else {
            $data['motel_role_id'] = null;
        }
        $data['role'] = 'bnbreceiptionist';
        $data['password'] = Hash::make($request->password);
        $data['motel_id'] = $motel->id;
        $data['createdby'] = $user->id;
        $data['status'] = 'active';

        if ($request->hasFile('profileimage')) {
            $imagePath = $request->file('profileimage')->store('users', 'public');
            $data['profileimage'] = $imagePath;
        }

        BnbUser::create($data);
        
        return redirect()->route('bnbowner.staff-management.index')
                       ->with('success', 'Staff member created successfully.');
    }
    
    public function edit($id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->route('bnbowner.motel-selection');
        }
        
        $staff = BnbUser::where('id', $id)
                       ->where('motel_id', $motel->id)
                       ->first();
        
        if (!$staff) {
            return redirect()->back()->with('error', 'Staff member not found.');
        }

        $motelRoles = MotelRole::where('motel_id', $motel->id)->orderBy('name')->get();
        // Other motels owned by this user (for transfer option), excluding current motel
        $ownedMotels = Motel::where('owner_id', $user->id)
            ->where('id', '!=', $motel->id)
            ->orderBy('name')
            ->get();
        return view('bnbowner.staff-management.edit', compact('motel', 'staff', 'motelRoles', 'ownedMotels'))->with('selectedMotel', $motel);
    }
    
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
        
        $staff = BnbUser::where('id', $id)
                       ->where('motel_id', $motel->id)
                       ->first();
        
        if (!$staff) {
            return redirect()->back()->with('error', 'Staff member not found.');
        }
        
        $request->validate([
            'username' => 'required|string|max:255',
            'useremail' => 'required|email|unique:bnb_users,useremail,' . $id . ',id|max:255',
            'telephone' => 'nullable|string|max:20',
            'motel_role_id' => 'nullable|exists:motel_roles,id',
            'profileimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['username', 'useremail', 'telephone', 'motel_role_id']);
        if (array_key_exists('motel_role_id', $data) && $data['motel_role_id'] !== null && $data['motel_role_id'] !== '') {
            $roleBelongsToMotel = MotelRole::where('id', $data['motel_role_id'])->where('motel_id', $motel->id)->exists();
            if (!$roleBelongsToMotel) {
                return redirect()->back()->withInput()->with('error', 'Selected role is not valid for this motel.');
            }
        } else {
            $data['motel_role_id'] = null;
        }

        if ($request->hasFile('profileimage')) {
            if ($staff->profileimage && Storage::exists('public/' . $staff->profileimage)) {
                Storage::delete('public/' . $staff->profileimage);
            }
            $imagePath = $request->file('profileimage')->store('users', 'public');
            $data['profileimage'] = $imagePath;
        }

        $staff->update($data);
        
        return redirect()->route('bnbowner.staff-management.index')
                       ->with('success', 'Staff member updated successfully.');
    }

    public function resetPassword($id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');

        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();

        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }

        $staff = BnbUser::where('id', $id)
                       ->where('motel_id', $motel->id)
                       ->first();

        if (!$staff) {
            return redirect()->back()->with('error', 'Staff member not found.');
        }

        $newPassword = Str::random(10);
        $staff->update(['password' => Hash::make($newPassword)]);

        return redirect()
            ->route('bnbowner.staff-management.edit', $staff->id)
            ->with('success', 'Password reset successfully. Share the new password securely.')
            ->with('reset_password', $newPassword);
    }
    
    public function toggleStatus($id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');
        
        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();
        
        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }
        
        $staff = BnbUser::where('id', $id)
                       ->where('motel_id', $motel->id)
                       ->first();
        
        if (!$staff) {
            return redirect()->back()->with('error', 'Staff member not found.');
        }
        
        // Toggle status between active and inactive
        $newStatus = $staff->status === 'active' ? 'inactive' : 'active';
        $staff->update(['status' => $newStatus]);
        
        $action = $newStatus === 'active' ? 'unblocked' : 'blocked';
        
        return redirect()->route('bnbowner.staff-management.index')
                       ->with('success', "Staff member {$action} successfully.");
    }

    /**
     * Transfer staff member to another BNB/motel owned by the same owner.
     * Requires account password confirmation.
     */
    public function transfer(Request $request, $id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');

        $motel = Motel::where('id', $selectedMotelId)
                     ->where('owner_id', $user->id)
                     ->first();

        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }

        $staff = BnbUser::where('id', $id)
                       ->where('motel_id', $motel->id)
                       ->first();

        if (!$staff) {
            return redirect()->back()->with('error', 'Staff member not found.');
        }

        $request->validate([
            'target_motel_id' => 'required|exists:bnb_motels,id',
            'password' => 'required|string',
        ]);

        $targetMotel = Motel::where('id', $request->target_motel_id)
                            ->where('owner_id', $user->id)
                            ->first();

        if (!$targetMotel) {
            return redirect()->back()->with('error', 'You can only transfer to a BNB that you own.');
        }

        if ((int) $targetMotel->id === (int) $motel->id) {
            return redirect()->back()->with('error', 'Staff is already in this BNB. Choose a different one.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Incorrect account password. Transfer cancelled.');
        }

        $staff->update([
            'motel_id' => $targetMotel->id,
            'motel_role_id' => null, // Role is per-motel; clear so owner can assign in new BNB
        ]);

        return redirect()
            ->route('bnbowner.staff-management.index')
            ->with('success', "Staff member {$staff->username} has been transferred to {$targetMotel->name}.");
    }
}
