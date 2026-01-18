<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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

    public function profile(){
        $user = Auth::User();
        return view('page.user.profile',  compact('user'));
    }

    public function updateData(Request $request){
        $user = Auth::User();

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'phone' => 'nullable|regex:/^[0-9+\s]+$/|max:20',
            'address' => 'nullable|string|min:5|regex:/[a-zA-Z]/',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'password' => 'nullable|confirmed',
        ]);

        if ($request->hasFile('profile_photo')) {

            if($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)){
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')->store('profile', 'public');
            $user->profile_photo = $path;
        }

        $user->name = $data['name'];
        $user->address = $data['address'] ?? $user->address;

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        if(!$user->isDirty()){
            return back()->with('error', 'Tidak ada perubahan yang disimpan');
        }

        $user->save();
        // $user->update($data);
        //Auth()->login($user);
        // dd($request->all());

        return redirect()->route('user.profile')->with('success', 'Profil telah berhasil diperbarui!');
    }
}