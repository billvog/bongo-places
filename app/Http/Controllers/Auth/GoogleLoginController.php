<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller {
	public function redirectToProvider() {
		return Socialite::driver('google')->redirect();
	}

	public function handleProviderCallback() {
		$googleUser = Socialite::driver('google')->user();

		$user = User::updateOrCreate([
			'email' => $googleUser->getEmail(),
		], [
			'name' => $googleUser->getName(),
			'avatar_url' => $googleUser->getAvatar(),
			'google_id' => $googleUser->getId(),
			'google_token' => $googleUser->token,
			'google_refresh_token' => $googleUser->refreshToken,
		]);

		Auth::login($user, true);

		return redirect('/dashboard');
	}
}
