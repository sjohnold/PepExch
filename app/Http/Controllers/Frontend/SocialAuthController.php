<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // Redirect (WEB)
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // Callback (WEB)
    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        try{
            $user = User::updateOrCreate(
                [
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ],
                [
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt(Str::random(16)),
                    'provider_img_url' => $socialUser->avatar,
                ]
            );
            auth()->login($user);
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Authentication failed. Please try again.');
        }

        return redirect()->route('home')->with('success', 'Login successful!');
    }
}
