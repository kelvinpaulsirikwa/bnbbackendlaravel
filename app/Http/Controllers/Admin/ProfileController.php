<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends AdminBaseController
{
    /**
     * Show the admin profile management page.
     */
    public function edit()
    {
        /** @var \App\Models\BnbUser $user */
        $user = Auth::user();

        return view('adminpages.profile.edit', compact('user'));
    }

    /**
     * Update admin profile details.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:25'],
        ]);

        /** @var \App\Models\BnbUser $user */
        $user = Auth::user();
        $user->username = $request->input('username');
        $user->telephone = $request->input('telephone');
        $user->save();

        return redirect()
            ->back()
            ->with('success_profile', 'Profile details updated successfully.');
    }

    /**
     * Update admin profile avatar.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'profile_image' => ['required', 'image', 'max:2048'],
        ]);

        /** @var \App\Models\BnbUser $user */
        $user = Auth::user();

        $existingImage = $user->profileimage
            ? ltrim(str_replace('storage/', '', $user->profileimage), '/')
            : null;

        if ($existingImage && Storage::disk('public')->exists($existingImage)) {
            Storage::disk('public')->delete($existingImage);
        }

        $path = $request->file('profile_image')->store('profile_images', 'public');

        $user->profileimage = $path;
        $user->save();

        return redirect()
            ->back()
            ->with('success_avatar', 'Profile picture updated successfully.');
    }

    /**
     * Change admin password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        /** @var \App\Models\BnbUser $user */
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()
            ->back()
            ->with('success_password', 'Password updated successfully.');
    }
}


