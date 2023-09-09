<?php

namespace App\Http\Controllers\Auth;

use Closure;
use App\Models\User\User;
use App\Http\Controllers\Controller;
use App\Models\OAuthProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteLoginController extends Controller {
	public function redirectToProvider(string $provider) {
		return Socialite::driver($provider)->redirect();
	}

	public function handleProviderCallback(string $provider) {
		$oathUser = Socialite::driver($provider)->user();

		$user = User::updateOrCreate(
			['email' => $oathUser->getEmail()],
			[
				'name' => $oathUser->getName(),
				'avatar_url' => $oathUser->getAvatar(),
			]
		);

		OAuthProvider::updateOrCreate(
			['id' => $oathUser->getId()],
			[
				'token' => $oathUser->token,
				'refresh_token' => $oathUser->refreshToken,
				'expires_in' => $oathUser->expiresIn,
				'user_id' => $user->id
			]
		);

		Auth::login($user, true);

		return redirect()->route('index');
	}
}
