<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Upload da foto de perfil
        if ($request->hasFile('photo')) {
            // Remove a foto antiga se existir
            if ($user->photo) {
                \Storage::disk('public')->delete($user->photo);
            }
            $photoPath = $request->file('photo')->store('users/photos', 'public');
            $user->photo = $photoPath;
        }

        // Upload da logo personalizada
        if ($request->hasFile('logo')) {
            // Remove a logo antiga se existir
            if ($user->logo) {
                \Storage::disk('public')->delete($user->logo);
            }
            $logoPath = $request->file('logo')->store('users/logos', 'public');
            $user->logo = $logoPath;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
