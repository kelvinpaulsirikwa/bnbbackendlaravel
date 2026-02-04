<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\BnbUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BnbUserController extends AdminBaseController
{
    public function index(Request $request)
    {
        $query = BnbUser::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('useremail', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $users = $query->orderBy('username')->paginate(20);
        
        return view('adminpages.users.index', compact('users'));
    }

    public function create()
    {
        return view('adminpages.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|max:255',
            'useremail' => 'required|email|unique:bnb_users,useremail',
            'password' => 'required|string|min:6|confirmed',
            'telephone' => 'nullable|string',
            'status' => 'required|in:active,unactive',
            'user_type' => 'required|in:admin,owner',
            'admin_permissions' => 'nullable|array',
            'admin_permissions.*' => 'string|in:' . implode(',', array_keys(config('admin_permissions', []))),
            'profileimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data['role'] = $data['user_type'] === 'admin' ? 'bnbadmin' : 'bnbowner';
        $data['admin_permissions'] = $data['user_type'] === 'admin' ? array_values($data['admin_permissions'] ?? []) : null;
        unset($data['user_type']);

        // Handle profile image upload
        if ($request->hasFile('profileimage')) {
            $image = $request->file('profileimage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/users'), $imageName);
            $data['profileimage'] = 'images/users/' . $imageName;
        }

        $data['password'] = Hash::make($data['password']);
        $data['createdby'] = auth()->id();

        $user = BnbUser::create($data);
        
        return redirect()->route('adminpages.users.index')
                        ->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = BnbUser::findOrFail($id);
        return view('adminpages.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = BnbUser::findOrFail($id);
        return view('adminpages.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = BnbUser::findOrFail($id);

        $data = $request->validate([
            'username' => 'required|string|max:255',
            'useremail' => 'required|email|unique:bnb_users,useremail,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'telephone' => 'nullable|string',
            'status' => 'required|in:active,unactive',
            'user_type' => 'required|in:admin,owner',
            'admin_permissions' => 'nullable|array',
            'admin_permissions.*' => 'string|in:' . implode(',', array_keys(config('admin_permissions', []))),
            'profileimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data['role'] = $data['user_type'] === 'admin' ? 'bnbadmin' : 'bnbowner';
        $data['admin_permissions'] = $data['user_type'] === 'admin' ? array_values($data['admin_permissions'] ?? []) : null;
        unset($data['user_type']);

        // Handle profile image upload
        if ($request->hasFile('profileimage')) {
            // Delete old image if exists
            if ($user->profileimage && file_exists(public_path($user->profileimage))) {
                unlink(public_path($user->profileimage));
            }
            
            $image = $request->file('profileimage');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/users'), $imageName);
            $data['profileimage'] = 'images/users/' . $imageName;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        
        return redirect()->route('adminpages.users.index')
                        ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = BnbUser::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot deactivate your own account.');
        }

        $user->status = 'unactive';
        $user->save();
        
        return redirect()->route('adminpages.users.index')
                        ->with('success', 'User deactivated successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,unactive',
        ]);

        $user = BnbUser::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot change your own status.');
        }

        $user->status = $request->input('status');
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }
}
