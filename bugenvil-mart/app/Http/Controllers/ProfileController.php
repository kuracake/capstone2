<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\UserAddress; // Pastikan Model ini dipanggil
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // TAMBAHAN: Ambil alamat user untuk ditampilkan
        $addresses = UserAddress::where('user_id', $request->user()->id)->get();

        return view('profile.edit', [
            'user' => $request->user(),
            'addresses' => $addresses, // Kirim ke view
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * FITUR BARU: Update Alamat Spesifik
     */
    public function updateAddress(Request $request, $id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'province_id' => 'required',
            'province_name' => 'required',
            'city_id' => 'required',
            'city_name' => 'required',
            'district_id' => 'required',
            'district_name' => 'required',
            'village_name' => 'required|string', // Pastikan desa diisi
            'address_detail' => 'required|string',
            'postal_code' => 'required',
        ]);

        $address->update([
            'province_id' => $request->province_id,
            'province_name' => $request->province_name,
            'city_id' => $request->city_id,
            'city_name' => $request->city_name,
            'district_id' => $request->district_id,
            'district_name' => $request->district_name,
            'village_name' => $request->village_name,
            'address_detail' => $request->address_detail,
            'postal_code' => $request->postal_code,
        ]);

        return back()->with('status', 'address-updated')->with('message', 'Alamat berhasil diperbarui!');
    }

    /**
     * FITUR BARU: Hapus Alamat
     */
    public function destroyAddress($id)
    {
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        return back()->with('status', 'address-deleted')->with('message', 'Alamat berhasil dihapus.');
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

    public function markNotification($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    $notification->markAsRead();
    return redirect($notification->data['link']);
}
}