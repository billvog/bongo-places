<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\OAuthProvider;
use Illuminate\Support\Facades\Auth;

class SocialAccountsController extends Controller {
	public function index() {
		$connectedSocialAccounts = OAuthProvider::query()->where('user_id', Auth::user()->id)->get();
		return view('account.social_accounts', [
			'connectedSocialAccounts' => $connectedSocialAccounts
		]);
	}
}
