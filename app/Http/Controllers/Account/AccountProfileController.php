<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountProfileRequest;
use Illuminate\Support\Facades\Auth;

class AccountProfileController extends Controller {
	public function index() {
		return view('account.profile');
	}

	public function update(UpdateAccountProfileRequest $request) {
		$user = Auth::user();
		$user->update($request->validated());
		return redirect()->action([AccountProfileController::class, 'index'])->with('notice', 'Account updated.');
	}
}
