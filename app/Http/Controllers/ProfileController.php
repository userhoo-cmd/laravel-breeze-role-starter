<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the profile form.
     * Admins can edit any user, others only themselves.
     */
    public function edit(Request $request, $id = null): View
    {
        // Admin can edit other users
        if ($id && Auth::user()->hasRole('admin')) {
            $user = User::findOrFail($id);
        } else {
            $user = $request->user();
        }

        return view('profile.edit', compact('user'));
    }

    /**
     * Update profile info, including avatar upload.
     */
    public function update(ProfileUpdateRequest $request, $id = null): RedirectResponse
    {
        if ($id && Auth::user()->hasRole('admin')) {
            $user = User::findOrFail($id);
        } else {
            $user = $request->user();
        }

        // Fill user info (name, email, etc.)
        $user->fill($request->validated());

        // Reset email verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Store in storage/app/public/avatars
            $file->storeAs('public/avatars', $filename);

            // Delete old avatar if exists
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            $user->avatar = $filename;
        }

        $user->save();

        return Redirect::route('profile.edit', $user->id ?? null)
            ->with('status', 'profile-updated');
    }

    /**
     * Delete account (self only).
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Delete avatar file if exists
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
