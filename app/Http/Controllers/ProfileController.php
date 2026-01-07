<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan form edit profil.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update informasi profil (nama, email, phone, address, avatar).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Ambil data yang sudah divalidasi, kecuali avatar (karena butuh proses upload)
        $validated = $request->validated();

        // Handle upload avatar jika ada
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru
            $filename = 'avatar-' . $user->id . '-' . time() . '.' . $request->file('avatar')->extension();
            $validated['avatar'] = $request->file('avatar')->storeAs('avatars', $filename, 'public');
        } else {
            // Jika tidak ada file baru, jangan ubah avatar (hilangkan dari validated)
            unset($validated['avatar']);
        }

        // Reset email_verified_at jika email berubah
        if ($user->email !== $validated['email']) {
            $validated['email_verified_at'] = null;
        }

        // Update user
        $user->update($validated);

        return Redirect::route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update avatar saja (misalnya via tombol "Ganti Foto" terpisah atau AJAX).
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048', 'dimensions:min_width=100,min_height=100'],
        ]);

        $user = $request->user();

        // Hapus avatar lama
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Simpan avatar baru
        $filename = 'avatar-' . $user->id . '-' . time() . '.' . $request->file('avatar')->extension();
        $path = $request->file('avatar')->storeAs('avatars', $filename, 'public');

        $user->update(['avatar' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Hapus foto profil.
     */
    public function deleteAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => bcrypt($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Hapus akun permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Hapus avatar jika ada
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
