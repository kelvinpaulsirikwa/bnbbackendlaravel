<?php

namespace App\Http\Controllers\BnBOwner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Motel;
use App\Models\MotelRole;

class RoleManagementController extends Controller
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

        $roles = MotelRole::where('motel_id', $motel->id)->orderBy('name')->get();
        $permissionLabels = config('motel_permissions.owner', []);

        return view('bnbowner.role-management.index', compact('motel', 'roles', 'permissionLabels'))
            ->with('selectedMotel', $motel);
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

        $permissionLabels = config('motel_permissions.owner', []);

        return view('bnbowner.role-management.create', compact('motel', 'permissionLabels'))
            ->with('selectedMotel', $motel);
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

        $permKeys = array_keys(config('motel_permissions.owner', []));
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . (empty($permKeys) ? '' : implode(',', $permKeys)),
        ]);

        $permissions = $request->input('permissions', []);
        MotelRole::create([
            'motel_id' => $motel->id,
            'name' => $request->name,
            'permissions' => array_values($permissions),
        ]);

        return redirect()->route('bnbowner.role-management.index')
            ->with('success', 'Role created successfully.');
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

        $role = MotelRole::where('id', $id)->where('motel_id', $motel->id)->firstOrFail();
        $permissionLabels = config('motel_permissions.owner', []);

        return view('bnbowner.role-management.edit', compact('motel', 'role', 'permissionLabels'))
            ->with('selectedMotel', $motel);
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

        $role = MotelRole::where('id', $id)->where('motel_id', $motel->id)->firstOrFail();

        $permKeys = array_keys(config('motel_permissions.owner', []));
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:' . (empty($permKeys) ? '' : implode(',', $permKeys)),
        ]);

        $permissions = $request->input('permissions', []);
        $role->update([
            'name' => $request->name,
            'permissions' => array_values($permissions),
        ]);

        return redirect()->route('bnbowner.role-management.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $selectedMotelId = session('selected_motel_id');

        $motel = Motel::where('id', $selectedMotelId)
            ->where('owner_id', $user->id)
            ->first();

        if (!$motel) {
            return redirect()->back()->with('error', 'Motel not found.');
        }

        $role = MotelRole::where('id', $id)->where('motel_id', $motel->id)->firstOrFail();
        $role->delete();

        return redirect()->route('bnbowner.role-management.index')
            ->with('success', 'Role deleted successfully.');
    }
}
