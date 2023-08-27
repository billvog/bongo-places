<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MyPlacesController extends Controller {
	public function index() {
		return view('my-places.index', [
			'places' => Auth::user()->places
		]);
	}
}
