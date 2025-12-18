<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use GuzzleHttp\Exception\ClientException;
use Exception;

class GoogleController extends Controller
{
    /**
     * Redirect user ke halaman autentikasi Google.
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(['email', 'profile']) // atau ['openid', 'profile', 'email']
            ->redirect();
    }

    /**
     * Handle callback dari Google setelah autentikasi.
     */
    public function callback(): RedirectResponse
    {
        // Jika user membatalkan login
        if (request()->has('error')) {
            $error = request('error');

            if ($error === 'access_denied') {
                return redirect()
                    ->route('login')
                    ->with('info', 'Login dengan Google dibatalkan.');
            }

            return redirect()
                ->route('login')
                ->with('error', 'Terjadi kesalahan: ' . $error);
        }

        try {
            $googleUser = Socialite::driver('google')->user();

            $user = $this->findOrCreateUser($googleUser);

            Auth::login($user, true); // remember: true

            session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('success', 'Berhasil login dengan Google!');

        } catch (InvalidStateException $e) {
            return redirect()
                ->route('login')
                ->with('error', 'Session telah berakhir. Silakan coba lagi.');

        } catch (ClientException $e) {
            logger()->error('Google API Error: ' . $e->getMessage());

            return redirect()
                ->route('login')
                ->with('error', 'Terjadi kesalahan saat menghubungi Google. Coba lagi.');

        } catch (Exception $e) {
            logger()->error('OAuth Error: ' . $e->getMessage());

            return redirect()
                ->route('login')
                ->with('error', 'Gagal login. Silakan coba lagi.');
        }
    }

    /**
     * Cari user berdasarkan google_id atau email, jika tidak ada maka buat baru.
     *
     * @param  \Laravel\Socialite\Contracts\User  $googleUser
     * @return \App\Models\User
     */
    protected function findOrCreateUser($googleUser): User
    {
        // Cari berdasarkan google_id dulu (paling akurat)
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // Update avatar jika berubah
            if ($user->avatar !== $googleUser->getAvatar()) {
                $user->update(['avatar' => $googleUser->getAvatar()]);
            }

            return $user;
        }

        // Jika tidak ada google_id, coba cari berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Hubungkan akun existing dengan Google
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar() ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);

            return $user;
        }

        // Buat user baru
        return User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
            'password' => bcrypt(Str::random(24)), // atau Hash::make(...)
            'role' => 'customer',
        ]);
    }
}
