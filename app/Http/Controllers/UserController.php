<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Refresh user from database to ensure latest data
        $user = $user->fresh();
        return view('users.settings', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $request->validate([
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $data = $request->only('name', 'email');

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new profile picture
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $data['profile_picture'] = $path;
        }

        $user->update($data);

        if ($request->filled('new_password')) {
            $user->update(['password' => Hash::make($request->new_password)]);
        }

        return redirect()->back()->with('success', '✅ Profile updated successfully!');
    }

    /**
     * Remove profile picture
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeProfilePicture(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user && $user->profile_picture) {
            try {
                // Delete file from storage if it exists
                if (Storage::disk('public')->exists($user->profile_picture)) {
                    Storage::disk('public')->delete($user->profile_picture);
                }
                
                // Clear profile picture from database
                $user->update(['profile_picture' => null]);

                return redirect()->route('settings')->with('success', '✅ Profile picture removed successfully!');
            } catch (\Exception $e) {
                return redirect()->route('settings')->with('error', '❌ Error removing profile picture: ' . $e->getMessage());
            }
        }

        return redirect()->route('settings')->with('error', '❌ No profile picture to remove.');
    }
}
